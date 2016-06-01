import $ from 'jquery';
import Api from './../Api';
import utils from './../utils';
import EditModal from './edit-modal';

export default {
    components: {editModal: EditModal},

    directives: utils.directives,

    filters: {emoji: utils.emojiFilter},

    transitions: {fade: utils.fadeTransition},

    data() {
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

    compiled () {
        this.init = true;
        this.fetch();
    },

    methods: {
        fetch () {
            this.loading = true;

            Api.get({
                page: this.page,
                status: this.status,
                pageId: this.pageId
            })
            .done((data) => this._fetchDone(data));
        },

        _fetchDone (data) {
            if (!data.comments.length && this.page > 1) {
                this.page = this.redirected ? 1 : this.page - 1;
                this.redirected = true;
                return this.fetch();
            }

            data.comments.forEach((comment) => comment.mark = false);

            this.loading = false;
            this.comments = data.comments;
            this.pageCount = data.page_count;
            this.pagination = data.pagination;
            this.statusCount = data.status_count;

            this.$nextTick(() => {
                $(this.$el).find('[data-toggle="tooltip"]').tooltip();

                const id = utils.param('edit');

                if (id) {
                    Api.find(id).done((comment) => this.editComment = comment);
                }
            });
        },

        onCloseEdit (updated) {
            if (updated) {
                this.fetch();
            }

            this.editComment = null;

            window.location.hash = '';
        },

        markAll () {
            this.comments.forEach(comment => comment.mark = this.markedAll);
        },

        mark () {
            this.markedAll = this.comments.length === this.marked().length;
        },

        bulkUpdate (e) {
            e.preventDefault();

            const ids = this.marked().map(comment => comment.id);

            if (this.bulkAction && ids.length) {
                Api.update('', {
                    ids: ids,
                    status: this.bulkAction
                })
                .done(() => {
                    this.markedAll = false;
                    this.bulkAction = 0;
                    this.fetch();
                });
            }
        },

        marked () {
            return this.comments.filter((comment) => comment.mark);
        },

        updateStatus (comment, status, e) {
            this.highlight(e, status);

            Api.update(comment.id, {status: status})
               .done(() => this.fetch());
        },

        destroy (comment, e) {
            this.highlight(e, 'trash');

            Api.destroy(comment.id)
               .done(() => this.fetch());
        },

        highlight (e, status) {
            e.preventDefault();

            const tr = $(e.target).closest('tr');

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

        highlighted (comment) {
            return comment.status === 'pending' && this.status !== 'pending';
        }
    }
}
