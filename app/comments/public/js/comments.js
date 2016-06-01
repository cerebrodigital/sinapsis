(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('vue'), require('jquery'), require('prism'), require('autosize')) :
    typeof define === 'function' && define.amd ? define(['vue', 'jquery', 'prism', 'autosize'], factory) :
    (factory(global.Vue,global.jQuery,global.Prism,global.autosize));
}(this, function (Vue,$,Prism,autosize) { 'use strict';

    Vue = 'default' in Vue ? Vue['default'] : Vue;
    $ = 'default' in $ ? $['default'] : $;
    Prism = 'default' in Prism ? Prism['default'] : Prism;
    autosize = 'default' in autosize ? autosize['default'] : autosize;

    var babelHelpers = {};

    babelHelpers.classCallCheck = function (instance, Constructor) {
      if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
      }
    };

    babelHelpers.createClass = function () {
      function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
          var descriptor = props[i];
          descriptor.enumerable = descriptor.enumerable || false;
          descriptor.configurable = true;
          if ("value" in descriptor) descriptor.writable = true;
          Object.defineProperty(target, descriptor.key, descriptor);
        }
      }

      return function (Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);
        if (staticProps) defineProperties(Constructor, staticProps);
        return Constructor;
      };
    }();

    babelHelpers;

    var instance = undefined;

    var Api = function () {
        /**
         * Create a new api instance.
         */

        function Api() {
            babelHelpers.classCallCheck(this, Api);

            if (!instance) {
                instance = this;
            }

            return instance;
        }

        /**
         * Configure api.
         *
         * @param {Object} routes
         * @param {String} token
         */


        babelHelpers.createClass(Api, [{
            key: 'configure',
            value: function configure(routes, token) {
                this.routes = routes;

                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token } });
            }

            /**
             * Retrieve comments.
             *
             * @param  {Object} args
             * @return {Object}
             */

        }, {
            key: 'get',
            value: function get(args) {
                return this.req(this.route('index'), 'GET', args);
            }

            /**
             * Store a comment.
             *
             * @param  {Object} data
             * @return {Object}
             */

        }, {
            key: 'store',
            value: function store(data) {
                return this.req(this.route('store'), 'POST', data);
            }

            /**
             * Find a comment by id.
             *
             * @param  {Number} id
             * @return {Object}
             */

        }, {
            key: 'find',
            value: function find(id) {
                return this.req(this.route('show', { id: id }), 'GET');
            }

            /**
             * Update a comment.
             *
             * @param  {Number} id
             * @param  {Object} data
             * @return {Object}
             */

        }, {
            key: 'update',
            value: function update(id, data) {
                var route = this.route('update', { id: id });

                if (!id) {
                    route = route.substr(0, route.length - 1);
                }

                return this.req(route, 'PUT', data);
            }

            /**
             * Delete a comment.
             *
             * @param  {Number} id
             * @return {object}
             */

        }, {
            key: 'destroy',
            value: function destroy(id) {
                return this.req(this.route('destroy', { id: id }), 'DELETE');
            }

            /**
             * Vote a comment.
             *
             * @param  {Number} id
             * @param  {Number} type
             * @return {Object}
             */

        }, {
            key: 'vote',
            value: function vote(id, type) {
                return this.req(this.route('vote', { id: id }), 'POST', { type: type });
            }

            /**
             * Update settings.
             *
             * @param  {Array} settings
             * @return {Object}
             */

        }, {
            key: 'updateSettings',
            value: function updateSettings(settings) {
                return this.req(this.route('settings'), 'PUT', { settings: settings });
            }

            /**
             * Get the URL to a named route.
             *
             * @param  {String} name
             * @param  {Object} params
             * @return {String}
             */

        }, {
            key: 'route',
            value: function route(name, params) {
                var route = this.routes[name] || '';

                if (params) {
                    for (var key in params) {
                        route = route.replace(':' + key, params[key]);
                    }
                }

                return route;
            }

            /**
             * Perform an ajax request.
             *
             * @param  {String} route
             * @param  {String} type
             * @param  {Object} data
             * @return {Object}
             */

        }, {
            key: 'req',
            value: function req(route, type) {
                var data = arguments.length <= 2 || arguments[2] === undefined ? {} : arguments[2];

                if (['POST', 'GET'].indexOf(type) < 0) {
                    data._method = type;
                    type = 'POST';
                }

                return $.ajax({
                    url: route,
                    type: type,
                    data: data,
                    dataType: 'json'
                });
            }
        }]);
        return Api;
    }();

    var Api$1 = instance ? instance : new Api();

    var Alert = {
        template: '#alert-template',

        props: ['success', 'errors'],

        computed: {
            text: function text() {
                return typeof this.errors === 'string';
            }
        },

        methods: {
            close: function close() {
                this.errors = null;
                this.success = null;
            }
        }
    };

    var utils = {
        /**
         * Build comment tree.
         *
         * @param  {Object} comment
         * @return {Object}
         */

        hierarchical: function hierarchical(comment) {
            comment.replies = buildTree(comment.replies, comment.id);
        },


        /**
         * Convert to a human readable date.
         *
         * @param  {String} selector
         * @return {String}
         */
        timeago: function timeago(selector) {
            if ($.fn.timeago) {
                $(selector).find('time').timeago();
            }
        },


        /**
         * Scroll to given position.
         *
         * @param {Number} scrollTop
         * @param {Number} speed
         */
        scroll: function scroll(scrollTop) {
            var speed = arguments.length <= 1 || arguments[1] === undefined ? 400 : arguments[1];

            $('body, html').animate({ scrollTop: scrollTop }, speed);
        },


        /**
         * Get url param.
         *
         * @param  {String} name
         * @param  {mixed} _default
         * @return {mixed}
         */
        param: function param(name, _default) {
            var fragment = extractParam('_escaped_fragment_', window.location.search);
            var str = fragment ? '#' + fragment : window.location.hash.replace('#!', '#');

            return parseInt(extractParam(name, str, true)) || _default;
        },


        /**
         * Highlight code blocks.
         *
         * @param {String} element
         */
        highlight: function highlight(element) {
            if (Prism) {
                $(element).find('pre code').each(function (i, block) {
                    Prism.highlightElement(block);
                });
            }
        },
        loadingDir: function loadingDir() {
            return {
                update: function update(value) {
                    var state = undefined,
                        text = 'Loading...';

                    if (typeof value === 'boolean') {
                        state = value;
                    } else {
                        state = value.state;
                        text = value.text || text;
                    }

                    this.el.disabled = !!state;

                    var $el = $(this.el);

                    if (state) {
                        this.originalText = $el.text();
                        $el.text(text);
                    } else if (this.originalText) {
                        $el.text(this.originalText);
                    }
                }
            };
        },


        directives: {
            loading: {
                update: function update(value) {
                    var state = undefined,
                        text = 'Loading...';

                    if (typeof value === 'boolean') {
                        state = value;
                    } else {
                        state = value.state;
                        text = value.text || text;
                    }

                    this.el.disabled = !!state;

                    var $el = $(this.el);

                    if (state) {
                        this.originalText = $el.text();
                        $el.text(text);
                    } else if (this.originalText) {
                        $el.text(this.originalText);
                    }
                }
            },

            disable: function disable(value) {
                this.el.disabled = !!value;
            }
        },

        fadeTransition: {
            enter: function enter(el, done) {
                $(el).css('opacity', 0).animate({ opacity: 1 }, 300, done);
            },
            enterCancelled: function enterCancelled(el) {
                $(el).stop();
            },
            leave: function leave(el, done) {
                $(el).animate({ opacity: 0 }, 300, done);
            },
            leaveCancelled: function leaveCancelled(el) {
                $(el).stop();
            }
        },

        emojiFilter: function emojiFilter(content) {
            if (window.twemoji) {
                return window.twemoji.parse(content, { size: 36 });
            }

            return content;
        }
    };

    /**
     * Extract param from query or hash.
     *
     * @param  {String}  name
     * @param  {String}  str
     * @param  {Boolean} isHash
     * @return {String|null}
     */
    var extractParam = function extractParam(name, str, isHash) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');

        var regex = new RegExp((isHash ? '[\\#]' : '[\\?&]') + name + '=([^&#]*)');
        var results = regex.exec(str);

        return results ? decodeURIComponent(results[1].replace(/\+/g, ' ')) : null;
    };

    /**
     * Build replies tree.
     *
     * @param  {Array}  comments
     * @param  {Number} parentId
     * @return {Array}
     */
    var buildTree = function buildTree(comments, parentId) {
        var result = [];

        comments.forEach(function (comment) {
            if (comment.parent_id === parentId) {
                comment.replies = buildTree(comments, comment.id);
                result.push(comment);
            }
        });

        return result;
    };

    var config = window.commentsConfig || window.adminConfig || {};

    var PostForm = {
        template: '#post-form-template',

        props: {
            total: { default: 0 },
            parent: { default: null },
            show: { type: Boolean, default: true },
            focus: { type: Boolean, default: false },
            commentList: { type: Array, default: function _default() {
                    return [];
                }
            }
        },

        components: { alert: Alert },

        directives: utils.directives,

        data: function data() {
            return {
                loading: false,
                errors: null,
                reWidgetId: null,
                content: '',
                authorName: '',
                authorEmail: '',
                authorUrl: '',
                captchaRequired: config.captchaRequired,
                maxLength: config.maxLength
            };
        },
        attached: function attached() {
            this.recallAuthor();

            if (this.focus) {
                this.onFocus();
            }
        },


        watch: {
            focus: function focus(val) {
                if (val) {
                    this.onFocus();
                }
            }
        },

        methods: {
            onFocus: function onFocus() {
                var _this = this;

                var $el = $(this.$el);
                var $textarea = $el.find('textarea');

                autosize($textarea);

                $textarea.focus();

                if (config.captchaRequired) {
                    this.$nextTick(function () {
                        _this.renderRecaptcha($el.find('#recaptcha')[0]);
                    });
                }
            },
            onSubmit: function onSubmit(e) {
                var _this2 = this;

                e.preventDefault();

                this.errors = null;
                this.loading = true;

                Api$1.store({
                    content: this.content,
                    author_name: this.authorName,
                    author_email: this.authorEmail,
                    author_url: this.authorUrl,
                    page_id: config.pageId,
                    parent_id: this.parent ? this.parent.id : null,
                    root_id: this.parent ? this.parent.root_id || this.parent.id : null,
                    permalink: config.permalink,
                    'g-recaptcha-response': this.recaptchaResponse()
                }).done(function (comment) {
                    return _this2.onSuccess(comment);
                }).fail(function (jqXHR) {
                    return _this2.onError(jqXHR);
                }).always(function () {
                    return _this2.loading = false;
                });
            },
            onSuccess: function onSuccess(comment) {
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
            onError: function onError(jqXHR) {
                this.errors = jqXHR.responseJSON || 'Unexpected error.';

                if (this.reWidgetId !== null) {
                    window.grecaptcha.reset(this.reWidgetId);
                }
            },
            cancel: function cancel() {
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
            recallAuthor: function recallAuthor() {
                var author = window.localStorage.getItem(config.storageKey);

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
            rememberAuthor: function rememberAuthor() {
                window.localStorage.setItem(config.storageKey, JSON.stringify({
                    name: this.authorName,
                    email: this.authorEmail,
                    url: this.authorUrl
                }));
            },


            /**
             * Render reCAPTCHA widget.
             *
             * @param {String} container
             */
            renderRecaptcha: function renderRecaptcha(container) {
                this.reWidgetId = window.grecaptcha.render(container, {
                    sitekey: config.recaptcha
                });
            },


            /**
             * Get reCAPTCHA response.
             *
             * @return {String}
             */
            recaptchaResponse: function recaptchaResponse() {
                if (this.reWidgetId === null) {
                    return;
                }

                try {
                    return window.grecaptcha.getResponse(this.reWidgetId);
                } catch (err) {
                    //
                }
            },
            authorized: function authorized() {
                return config.authorized;
            },
            user: function user() {
                return config.user;
            }
        }
    };

    var UP = 'up';
    var DOWN = 'down';
    var REMOVE = 'remove';

    Vue.component('comment', {
        template: '#comment-template',

        components: { alert: Alert, postForm: PostForm },

        props: ['comment', 'config', 'parent', 'target', 'total'],

        directives: utils.directives,

        filters: { emoji: utils.emojiFilter },

        transitions: { fade: utils.fadeTransition },

        data: function data() {
            return {
                collapsed: false,
                showEdit: false,
                showReply: false,
                content: '',
                errors: null,
                loading: false,
                maxLength: config.maxLength
            };
        },
        created: function created() {
            var _this = this;

            this.$on('comment.' + this.comment.id, function (comment) {
                _this.comment.replies.unshift(comment);
            });
        },
        ready: function ready() {
            utils.timeago(this.$el);
            utils.highlight(this.$el);

            // const iframe = $(this.$el).find('iframe');
            // iframe.addClass('embed-responsive-item');
            // iframe.wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        },


        computed: {
            moderate: function moderate() {
                return config.user && config.user.admin;
            },
            editable: function editable() {
                return this.comment.canEdit && this.comment.status === 'approved' || this.moderate;
            },
            upvoted: function upvoted() {
                return this.comment.voted === UP;
            },
            downvoted: function downvoted() {
                return this.comment.voted === DOWN;
            }
        },

        methods: {
            /**
             * Toggle reply form.
             */

            reply: function reply(e) {
                e.preventDefault();

                this.showReply = !this.showReply;
            },


            /**
             * Show edit form.
             */
            edit: function edit(e) {
                var _this2 = this;

                e.preventDefault();

                this.showEdit = true;

                if (this.showReply) {
                    this.showReply = false;
                }

                this.$nextTick(function () {
                    autosize($(_this2.$el).find('textarea'));
                });
            },


            /**
             * Save comment.
             */
            save: function save(e) {
                var _this3 = this;

                e.preventDefault();

                this.loading = true;

                Api$1.update(this.comment.id, { content: this.content }).done(function (comment) {
                    _this3.showEdit = false;
                    _this3.errors = null;
                    _this3.content = '';
                    _this3.comment.content = comment.content;
                    _this3.comment.contentHTML = comment.contentHTML;
                    _this3.comment.status = comment.status;

                    _this3.$nextTick(function () {
                        utils.highlight(_this3.$el);
                    });
                }).always(function () {
                    _this3.loading = false;
                }).fail(function (jqXHR) {
                    _this3.errors = jqXHR.responseJSON || 'Unexpected error.';
                });
            },


            /**
             * Upvote comment.
             */
            upvote: function upvote(e) {
                this.vote(UP, e);
            },


            /**
             * Downvote comment.
             */
            downvote: function downvote(e) {
                this.vote(DOWN, e);
            },


            /**
             * Vote comment.
             *
             * @param {string} type
             */
            vote: function vote(type, e) {
                e.preventDefault();

                if (!config.user) {
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

                    Api$1.vote(this.comment.id, REMOVE);

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

                Api$1.vote(this.comment.id, type);
            },
            votes: function votes() {
                return config.votes;
            },
            replies: function replies() {
                return config.replies;
            }
        }
    });

    var Listener = function () {
        /**
         * Create a new instance.
         *
         * @param {String} channel
         * @param {Object} config
         */

        function Listener(channel, config) {
            babelHelpers.classCallCheck(this, Listener);

            this.channel = channel;
            this.driver = config.driver;
            this.instance = this.createDriver(config);
        }

        /**
         * Listen for events.
         *
         * @param  {String}   event
         * @param  {Function} callback
         * @return {Object}
         */


        babelHelpers.createClass(Listener, [{
            key: 'on',
            value: function on(event, callback) {
                switch (this.driver) {
                    case 'pusher':
                        return this.instance.subscribe(this.channel).bind(event, callback);

                    case 'redis':
                        return this.instance.on(this.channel + ':' + event, callback);
                }
            }

            /**
             * Create a new driver instance.
             *
             * @param  {Object} config
             * @return {Object}
             */

        }, {
            key: 'createDriver',
            value: function createDriver(config) {
                switch (config.driver) {
                    case 'pusher':
                        return new Pusher(config.pusherKey);

                    case 'redis':
                        return io(config.socket);
                }
            }
        }]);
        return Listener;
    }();

    Api$1.configure(config.routes, config.csrfToken);

    var Comments = {
        template: '#comments-template',

        directives: utils.directives,

        components: { postForm: PostForm },

        transitions: { fade: utils.fadeTransition },

        data: function data() {
            return {
                loading: false,
                initialized: false,

                sort: null,
                sortText: '',
                sortOptions: config.sortOptions,

                page: utils.param('page', 1),
                target: utils.param('comment', null),

                total: 0,
                pagination: {},
                commentList: []
            };
        },
        compiled: function compiled() {
            this.sortBy(config.sortBy);

            if (config.broadcasting) {
                this.initListener();
            }
        },


        methods: {
            /**
             * Fetch comments.
             */

            fetch: function fetch() {
                this.loading = true;

                Api$1.get({
                    page: this.page,
                    sort: this.sort,
                    target: this.target,
                    page_id: config.pageId
                }).done(this._fetchDone.bind(this));
            },


            /**
             * Fetch done callback.
             *
             * @param {Object} data
             */
            _fetchDone: function _fetchDone(data) {
                var _this = this;

                data.comments.forEach(utils.hierarchical);

                this.total = data.total;
                this.pagination = data.pagination;
                this.commentList = data.comments;

                this.loading = false;
                this.initialized = true;

                // Scroll to target comment.
                if (this.target) {
                    this.$nextTick(function () {
                        var comment = $('#comment-' + _this.target);

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
            sortBy: function sortBy(sort, e) {
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
            changePage: function changePage(page, e) {
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
            initListener: function initListener() {
                var _this2 = this;

                var listener = new Listener('comment.' + config.pageId, config.broadcasting);

                listener.on('Hazzard\\Comments\\Events\\BroadcastCommentWasPosted', function (data) {
                    _this2.pushComment(data.comment);
                });
            },


            /**
             * Push comment into the list.
             *
             * @param {Object} data
             */
            pushComment: function pushComment(comment) {
                if (comment.uid === config.uid) {
                    return false;
                }

                this.total += 1;

                if (comment.parent_id) {
                    this.$broadcast('comment.' + comment.parent_id, comment);
                } else {
                    this.commentList.unshift(comment);
                }
            },
            authorized: function authorized() {
                return config.authorized;
            }
        }
    };

    Vue.component('comments', Comments);

}));