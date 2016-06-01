import $ from 'jquery';
import Prism from 'prism';

const utils = {
    /**
     * Build comment tree.
     *
     * @param  {Object} comment
     * @return {Object}
     */
    hierarchical (comment) {
        comment.replies = buildTree(comment.replies, comment.id);
    },

    /**
     * Convert to a human readable date.
     *
     * @param  {String} selector
     * @return {String}
     */
    timeago (selector) {
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
    scroll (scrollTop, speed = 400) {
        $('body, html').animate({scrollTop: scrollTop}, speed);
    },

    /**
     * Get url param.
     *
     * @param  {String} name
     * @param  {mixed} _default
     * @return {mixed}
     */
    param (name, _default) {
        let fragment = extractParam('_escaped_fragment_', window.location.search);
        let str = fragment ? `#${fragment}` : window.location.hash.replace('#!', '#');

        return parseInt(extractParam(name, str, true)) || _default;
    },

    /**
     * Highlight code blocks.
     *
     * @param {String} element
     */
    highlight (element) {
        if (Prism) {
            $(element).find('pre code').each((i, block) => {
                Prism.highlightElement(block);
            });
        }
    },

    loadingDir() {
        return {
            update (value) {
                let state, text = 'Loading...';

                if (typeof value === 'boolean') {
                    state = value;
                } else {
                    state = value.state;
                    text = value.text || text;
                }

                this.el.disabled = !!state;

                let $el = $(this.el);

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
            update (value) {
                let state, text = 'Loading...';

                if (typeof value === 'boolean') {
                    state = value;
                } else {
                    state = value.state;
                    text = value.text || text;
                }

                this.el.disabled = !!state;

                let $el = $(this.el);

                if (state) {
                    this.originalText = $el.text();
                    $el.text(text);
                } else if (this.originalText) {
                    $el.text(this.originalText);
                }
            }
        },

        disable: function (value) {
            this.el.disabled = !!value
        }
    },

    fadeTransition: {
        enter (el, done) {
            $(el).css('opacity', 0)
                 .animate({opacity: 1}, 300, done);
        },
        enterCancelled (el) {
            $(el).stop()
        },
        leave (el, done) {
            $(el).animate({opacity: 0}, 300, done);
        },
        leaveCancelled (el) {
            $(el).stop();
        }
    },

    emojiFilter (content) {
        if (window.twemoji) {
            return window.twemoji.parse(content, {size: 36});
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
let extractParam = (name, str, isHash) => {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');

    let regex = new RegExp((isHash ? '[\\#]' : '[\\?&]') + name + '=([^&#]*)');
    let results = regex.exec(str);

    return results ? decodeURIComponent(results[1].replace(/\+/g, ' ')) : null;
}

/**
 * Build replies tree.
 *
 * @param  {Array}  comments
 * @param  {Number} parentId
 * @return {Array}
 */
let buildTree = (comments, parentId) => {
    let result = [];

    comments.forEach((comment) => {
        if (comment.parent_id === parentId) {
            comment.replies = buildTree(comments, comment.id);
            result.push(comment);
        }
    });

    return result;
}

export default utils;
