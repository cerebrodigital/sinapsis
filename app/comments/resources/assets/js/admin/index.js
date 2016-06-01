import Vue from 'vue';
import Api from './../Api';
import Config from './../config';

Api.configure(Config.routes, Config.csrfToken);

import Settings from './settings';
import Dashboard from './dashboard';

Vue.config.debug = true;

new Vue({
    el: '#admin',

    components: {
        commentsSettings: Settings,
        commentsDashboard: Dashboard
    }
});
