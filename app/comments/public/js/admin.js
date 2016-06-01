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

    var config = window.commentsConfig || window.adminConfig || {};

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

    var Settings = {
        components: { alert: Alert },

        directives: utils.directives,

        data: function data() {
            return {
                success: null,
                loading: false
            };
        },
        ready: function ready() {
            var _this = this;

            $(this.$el).find('.nav-tabs a').on('click', function () {
                _this.success = null;
            });
        },


        methods: {
            save: function save(e) {
                var _this2 = this;

                e.preventDefault();

                this.loading = true;

                Api$1.updateSettings($(e.target).serializeArray()).done(function () {
                    return _this2.success = 'Your changes have been saved.';
                }).always(function () {
                    return _this2.loading = false;
                });
            }
        }
    };

    var EditModal = {
        template: '#edit-modal-template',

        components: { alert: Alert },

        directives: utils.directives,

        props: ['comment', 'onClose'],

        data: function data() {
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
            };
        },


        computed: {
            user: function user() {
                return this.comment && this.comment.user_id;
            }
        },

        ready: function ready() {
            var _this = this;

            $('#edit-modal').on('hide.bs.modal', function () {
                _this.onClose(_this.updated);

                _this.success = null;
                _this.loading = false;
                _this.updated = false;
            });
        },


        watch: {
            comment: function comment(_comment) {
                if (_comment) {
                    this.update(_comment);

                    $('#edit-modal').modal('show');

                    autosize($(this.$el).find('textarea'));
                }
            }
        },

        methods: {
            update: function update(comment) {
                this.status = comment.status;
                this.content = comment.content;
                this.authorUrl = comment.author.url;
                this.authorName = comment.author.name;
                this.authorEmail = comment.author.email;
            },
            save: function save(e) {
                var _this2 = this;

                e.preventDefault();

                this.success = null;
                this.loading = true;

                Api$1.update(this.comment.id, {
                    status: this.status,
                    content: this.content,
                    author_url: this.authorUrl,
                    author_name: this.authorName,
                    author_email: this.authorEmail
                }).done(function (comment) {
                    _this2.update(comment);
                    _this2.updated = true;
                    _this2.success = 'Your changes have been saved.';
                }).always(function () {
                    _this2.loading = false;
                });
            }
        }
    };

    var Dashboard = {
        components: { editModal: EditModal },

        directives: utils.directives,

        filters: { emoji: utils.emojiFilter },

        transitions: { fade: utils.fadeTransition },

        data: function data() {
            return {
                init: false,
                comments: [],
                page: 1,
                status: 'all',
                pageId: null,
                fetchRoute: null,
                pagination: {},
                statusCount: {},
                loading: true,
                redirected: false,
                bulkAction: 0,
                markedAll: false,
                editComment: null,
                statuses: ['all', 'pending', 'approved', 'spam', 'trash']
            };
        },
        compiled: function compiled() {
            this.init = true;
            this.fetch();
        },


        methods: {
            fetch: function fetch() {
                var _this = this;

                this.loading = true;

                Api$1.get({
                    page: this.page,
                    status: this.status,
                    pageId: this.pageId
                }).done(function (data) {
                    return _this._fetchDone(data);
                });
            },
            _fetchDone: function _fetchDone(data) {
                var _this2 = this;

                if (!data.comments.length && this.page > 1) {
                    this.page = this.redirected ? 1 : this.page - 1;
                    this.redirected = true;
                    return this.fetch();
                }

                data.comments.forEach(function (comment) {
                    return comment.mark = false;
                });

                this.loading = false;
                this.comments = data.comments;
                this.pageCount = data.page_count;
                this.pagination = data.pagination;
                this.statusCount = data.status_count;

                this.$nextTick(function () {
                    $(_this2.$el).find('[data-toggle="tooltip"]').tooltip();

                    var id = utils.param('edit');

                    if (id) {
                        Api$1.find(id).done(function (comment) {
                            return _this2.editComment = comment;
                        });
                    }
                });
            },
            onCloseEdit: function onCloseEdit(updated) {
                if (updated) {
                    this.fetch();
                }

                this.editComment = null;

                window.location.hash = '';
            },
            markAll: function markAll() {
                var _this3 = this;

                this.comments.forEach(function (comment) {
                    return comment.mark = _this3.markedAll;
                });
            },
            mark: function mark() {
                this.markedAll = this.comments.length === this.marked().length;
            },
            bulkUpdate: function bulkUpdate(e) {
                var _this4 = this;

                e.preventDefault();

                var ids = this.marked().map(function (comment) {
                    return comment.id;
                });

                if (this.bulkAction && ids.length) {
                    Api$1.update('', {
                        ids: ids,
                        status: this.bulkAction
                    }).done(function () {
                        _this4.markedAll = false;
                        _this4.bulkAction = 0;
                        _this4.fetch();
                    });
                }
            },
            marked: function marked() {
                return this.comments.filter(function (comment) {
                    return comment.mark;
                });
            },
            updateStatus: function updateStatus(comment, status, e) {
                var _this5 = this;

                this.highlight(e, status);

                Api$1.update(comment.id, { status: status }).done(function () {
                    return _this5.fetch();
                });
            },
            destroy: function destroy(comment, e) {
                var _this6 = this;

                this.highlight(e, 'trash');

                Api$1.destroy(comment.id).done(function () {
                    return _this6.fetch();
                });
            },
            highlight: function highlight(e, status) {
                e.preventDefault();

                var tr = $(e.target).closest('tr');

                switch (status) {
                    case 'trash':
                    case 'spam':
                        return tr.addClass('danger');

                    case 'pending':
                        return tr.addClass('warning');

                    case 'approved':
                        return tr.removeClass('warning').addClass('success');
                }
            },
            highlighted: function highlighted(comment) {
                return comment.status === 'pending' && this.status !== 'pending';
            }
        }
    };

    Api$1.configure(config.routes, config.csrfToken);

    Vue.config.debug = true;

    new Vue({
        el: '#admin',

        components: {
            commentsSettings: Settings,
            commentsDashboard: Dashboard
        }
    });

}));