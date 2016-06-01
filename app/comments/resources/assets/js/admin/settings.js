import $ from 'jquery';
import Api from './../Api';
import utils from './../utils';
import Alert from './../components/alert';

export default {
    components: {alert: Alert},

    directives: utils.directives,

    data() {
        return {
            success: null,
            loading: false
        };
    },

    ready () {
        $(this.$el).find('.nav-tabs a').on('click', () => {
            this.success = null;
        });
    },

    methods: {
        save (e) {
            e.preventDefault();

            this.loading = true;

            Api.updateSettings($(e.target).serializeArray())
                .done(() => this.success = 'Your changes have been saved.')
                .always(() => this.loading = false);
        }
    }
}
