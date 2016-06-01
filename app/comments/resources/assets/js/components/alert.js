export default {
    template: '#alert-template',

    props: ['success', 'errors'],

    computed: {
        text () {
            return typeof this.errors === 'string';
        }
    },

    methods: {
        close () {
            this.errors = null;
            this.success = null;
        }
    }
};
