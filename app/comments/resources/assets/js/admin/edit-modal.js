import $ from 'jquery';
import Api from './../Api';
import utils from './../utils';
import autosize from 'autosize';
import Alert from './../components/alert';

export default {
    template: '#edit-modal-template',

    components: {alert: Alert},

    directives: utils.directives,

    props: ['comment', 'onClose'],

    data () {
        return {
            status: '',
            content: '',
            authorUrl: '',
            authorName: '',
            authorEmail: '',
            success: null,
            loading: false,
            updated: false,
            statuses: ['all', 'pending', 'approved', 'spam', 'trash']
        }
    },

    computed: {
        user () {
            return this.comment && this.comment.user_id;
        }
    },

    ready () {
        $('#edit-modal').on('hide.bs.modal', () => {
            this.onClose(this.updated);

            this.success = null;
            this.loading = false;
            this.updated = false;
        });
    },

    watch: {
        comment (comment) {
            if (comment) {
                this.update(comment);

                $('#edit-modal').modal('show');

                autosize($(this.$el).find('textarea'));
            }
        }
    },

    methods: {
        update (comment) {
            this.status = comment.status;
            this.content = comment.content;
            this.authorUrl = comment.author.url;
            this.authorName = comment.author.name;
            this.authorEmail = comment.author.email;
        },

        save (e) {
            e.preventDefault();

            this.success = null;
            this.loading = true;

            Api.update(this.comment.id, {
                status: this.status,
                content: this.content,
                author_url: this.authorUrl,
                author_name: this.authorName,
                author_email: this.authorEmail
            })
            .done((comment) => {
                this.update(comment);
                this.updated = true;
                this.success = 'Your changes have been saved.';
            })
            .always(() => {
                this.loading = false;
            });
        }
    }
};
