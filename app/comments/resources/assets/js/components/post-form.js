import $ from 'jquery';
import Api from './../Api';
import Alert from './alert';
import utils from './../utils';
import autosize from 'autosize';
import Config from './../config';

export default {
    template: '#post-form-template',

    props: {
        total: {default: 0},
        parent: {default: null},
        show: {type: Boolean, default: true},
        focus: {type: Boolean, default: false},
        commentList: {type: Array, default() { return []; }}
    },

    components: {alert: Alert},

    directives: utils.directives,

    data () {
        return {
            loading: false,
            errors: null,
            reWidgetId: null,
            content: '',
            authorName: '',
            authorEmail: '',
            authorUrl: '',
            captchaRequired: Config.captchaRequired,
            maxLength: Config.maxLength
        };
    },

    attached () {
        this.recallAuthor();

        if (this.focus) {
            this.onFocus();
        }
    },

    watch: {
        focus (val) {
            if (val) {
                this.onFocus();
            }
        }
    },

    methods: {
        onFocus () {
            const $el = $(this.$el);
            const $textarea = $el.find('textarea');

            autosize($textarea);

            $textarea.focus();

            if (Config.captchaRequired) {
                this.$nextTick(() => {
                    this.renderRecaptcha($el.find('#recaptcha')[0]);
                })
            }
        },

        onSubmit(e) {
            e.preventDefault();

            this.errors = null;
            this.loading = true;

            Api.store({
                content: this.content,
                author_name: this.authorName,
                author_email: this.authorEmail,
                author_url: this.authorUrl,
                page_id: Config.pageId,
                parent_id: this.parent ? this.parent.id : null,
                root_id: this.parent ? (this.parent.root_id || this.parent.id) : null,
                permalink: Config.permalink,
                'g-recaptcha-response': this.recaptchaResponse()
            })
            .done((comment) => this.onSuccess(comment))
            .fail((jqXHR) => this.onError(jqXHR))
            .always(() => this.loading = false);
        },

        onSuccess (comment) {
            if (this.parent) {
                this.parent.replies.unshift(comment);
            } else {
                this.commentList.unshift(comment);
            }

            this.total += 1;

            if (this.parent) {
                this.show = false;
            } else {
                this.focus = false;
            }

            this.errors = null;
            this.content = '';

            this.rememberAuthor();
        },

        onError (jqXHR) {
            this.errors = jqXHR.responseJSON || 'Unexpected error.';

            if (this.reWidgetId !== null) {
                window.grecaptcha.reset(this.reWidgetId);
            }
        },

        cancel () {
            this.errors = null;

            if (this.parent) {
                this.show = false;
            } else {
                this.focus = false;
                this.content = '';
            }

            autosize.destroy($(this.$el).find('textarea'));
        },

        /**
         * Recall the author name, email and url from the browser local storage.
         */
        recallAuthor () {
            let author = window.localStorage.getItem(Config.storageKey);

            try {
                author = JSON.parse(author);
            } catch (error) {
                //
            }

            if (!author) {
                return false;
            }

            if (author.name) {
                this.authorName = author.name;
            }

            if (author.email) {
                this.authorEmail = author.email;
            }

            if (author.url) {
                this.authorUrl = author.url;
            }
        },

        /**
         * Remember the author name, email and url in the browser local storage.
         */
        rememberAuthor () {
            window.localStorage.setItem(Config.storageKey, JSON.stringify({
                name:  this.authorName,
                email: this.authorEmail,
                url:   this.authorUrl
            }));
        },

        /**
         * Render reCAPTCHA widget.
         *
         * @param {String} container
         */
        renderRecaptcha (container) {
            this.reWidgetId = window.grecaptcha.render(container, {
                sitekey : Config.recaptcha
            });
        },

        /**
         * Get reCAPTCHA response.
         *
         * @return {String}
         */
        recaptchaResponse () {
            if (this.reWidgetId === null) {
                return;
            }

            try {
                return window.grecaptcha.getResponse(this.reWidgetId);
            } catch (err) {
                //
            }
        },

        authorized () {
            return Config.authorized;
        },

        user () {
            return Config.user;
        }
    }
};
