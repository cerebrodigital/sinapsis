import Vue from 'vue';
import $ from 'jquery';
import Api from './../Api';
import Alert from './alert';
import utils from './../utils';
import autosize from 'autosize'
import Config from './../config';
import PostForm from './post-form';

const UP = 'up';
const DOWN = 'down';
const REMOVE = 'remove';

Vue.component('comment', {
    template: '#comment-template',

    components: {alert: Alert, postForm: PostForm},

    props: ['comment', 'config', 'parent', 'target', 'total'],

    directives: utils.directives,

    filters: {emoji: utils.emojiFilter},

    transitions: {fade: utils.fadeTransition},

    data () {
        return {
            collapsed: false,
            showEdit: false,
            showReply: false,
            content: '',
            errors: null,
            loading: false,
            maxLength: Config.maxLength
        };
    },

    created () {
        this.$on('comment.' + this.comment.id, (comment) => {
            this.comment.replies.unshift(comment);
        });
    },

    ready () {
        utils.timeago(this.$el);
        utils.highlight(this.$el);

        // const iframe = $(this.$el).find('iframe');
        // iframe.addClass('embed-responsive-item');
        // iframe.wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    },

    computed: {
        moderate () {
            return Config.user && Config.user.admin;
        },
        editable () {
            return (this.comment.canEdit && this.comment.status === 'approved') || this.moderate;
        },
        upvoted () {
            return this.comment.voted === UP;
        },
        downvoted () {
            return this.comment.voted === DOWN;
        }
    },

    methods: {
        /**
         * Toggle reply form.
         */
        reply (e) {
            e.preventDefault();

            this.showReply = !this.showReply;
        },

        /**
         * Show edit form.
         */
        edit (e) {
            e.preventDefault();

            this.showEdit = true;

            if (this.showReply) {
                this.showReply = false;
            }

            this.$nextTick(() => {
                autosize($(this.$el).find('textarea'));
            });
        },

        /**
         * Save comment.
         */
        save (e) {
            e.preventDefault();

            this.loading = true;

            Api.update(this.comment.id, {content: this.content})
            .done((comment) => {
                this.showEdit = false;
                this.errors = null;
                this.content = '';
                this.comment.content = comment.content;
                this.comment.contentHTML = comment.contentHTML;
                this.comment.status = comment.status;

                this.$nextTick(() => {
                    utils.highlight(this.$el);
                });
            })
            .always(() => {
                this.loading = false;
            })
            .fail((jqXHR) => {
                this.errors = jqXHR.responseJSON || 'Unexpected error.';
            });
        },

        /**
         * Upvote comment.
         */
        upvote (e) {
            this.vote(UP, e);
        },

        /**
         * Downvote comment.
         */
        downvote (e) {
            this.vote(DOWN, e);
        },

        /**
         * Vote comment.
         *
         * @param {string} type
         */
        vote (type, e) {
            e.preventDefault();

            if (!Config.user) {
                return alert('You must be logged in to vote!');
            }

            // Remove vote.

            if (this.comment.voted === type) {
                this.comment.voted = null;

                if (type === UP) {
                    this.comment.upvotes -= 1;
                } else {
                    this.comment.downvotes -= 1;
                }

                Api.vote(this.comment.id, REMOVE);

                return false;
            }

            // Vote.

            if (this.comment.voted === UP && type === DOWN) {
                this.comment.upvotes -= 1;
            } else if (this.comment.voted === DOWN && type === UP) {
                this.comment.downvotes -= 1;
            }

            this.comment.voted = type;

            if (type === UP) {
                this.comment.upvotes += 1;
            } else {
                this.comment.downvotes += 1;
            }

            Api.vote(this.comment.id, type);
        },

        votes () {
            return Config.votes;
        },

        replies () {
            return Config.replies;
        }
    }
});
