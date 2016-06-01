import './comment';
import $ from 'jquery';
import Api from './../Api';
import utils from './../utils';
import Config from './../config';
import PostForm from './post-form';
import Listener from './../Listener';

Api.configure(Config.routes, Config.csrfToken);

export default {
    template: '#comments-template',

    directives: utils.directives,

    components: {postForm: PostForm},

    transitions: {fade: utils.fadeTransition},

    data () {
        return {
            loading: false,
            initialized: false,

            sort: null,
            sortText: '',
            sortOptions: Config.sortOptions,

            page: utils.param('page', 1),
            target: utils.param('comment', null),

            total: 0,
            pagination: {},
            commentList: []
        }
    },

    compiled () {
        this.sortBy(Config.sortBy);

        if (Config.broadcasting) {
            this.initListener();
        }
    },

    methods: {
        /**
         * Fetch comments.
         */
        fetch () {
            this.loading = true;

            Api.get({
                page: this.page,
                sort: this.sort,
                target: this.target,
                page_id: Config.pageId
            })
            .done(this._fetchDone.bind(this));
        },

        /**
         * Fetch done callback.
         *
         * @param {Object} data
         */
        _fetchDone (data) {
            data.comments.forEach(utils.hierarchical);

            this.total = data.total;
            this.pagination = data.pagination;
            this.commentList = data.comments;

            this.loading = false;
            this.initialized = true;

            // Scroll to target comment.
            if (this.target) {
                this.$nextTick(() => {
                    const comment = $('#comment-' + this.target);

                    if (comment.length) {
                        utils.scroll(comment.offset().top - 15, 200);
                    }
                });
            }
        },

        /**
         * Sort comments.
         *
         * @param {Number} sort
         * @param {Object} e
         */
        sortBy (sort, e) {
            if (e) {
                e.preventDefault();

                this.page = 1;
                this.target = null;
            }

            if (sort !== this.sort || !e) {
                this.sort = sort;
                this.sortText = this.sortOptions[sort];

                this.fetch();
            }
        },

        /**
         * Change current page.
         *
         * @param {Number} page
         * @param {Object} e
         */
        changePage (page, e) {
            if (page) {
                utils.scroll($('.comments').offset().top);

                this.page = page;
                this.target = null;
                this.fetch();
            } else {
                e.preventDefault();
            }
        },

        /**
         * Initialize listener.
         */
        initListener () {
            const listener = new Listener('comment.' + Config.pageId, Config.broadcasting);

            listener.on('Hazzard\\Comments\\Events\\BroadcastCommentWasPosted', (data) => {
                this.pushComment(data.comment);
            });
        },

        /**
         * Push comment into the list.
         *
         * @param {Object} data
         */
        pushComment (comment) {
            if (comment.uid === Config.uid) {
                return false;
            }

            this.total += 1;

            if (comment.parent_id) {
                this.$broadcast('comment.' + comment.parent_id, comment);
            } else {
                this.commentList.unshift(comment);
            }
        },

        authorized () {
            return Config.authorized;
        }
    }
};
