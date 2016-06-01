import $ from 'jquery';

let instance;

class Api {
    /**
     * Create a new api instance.
     */
    constructor () {
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
    configure(routes, token) {
        this.routes = routes;

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': token}});
    }

    /**
     * Retrieve comments.
     *
     * @param  {Object} args
     * @return {Object}
     */
    get (args) {
        return this.req(this.route('index'), 'GET', args);
    }

    /**
     * Store a comment.
     *
     * @param  {Object} data
     * @return {Object}
     */
    store (data) {
        return this.req(this.route('store'), 'POST', data);
    }

    /**
     * Find a comment by id.
     *
     * @param  {Number} id
     * @return {Object}
     */
    find (id) {
        return this.req(this.route('show', {id: id}), 'GET');
    }

    /**
     * Update a comment.
     *
     * @param  {Number} id
     * @param  {Object} data
     * @return {Object}
     */
    update (id, data) {
        let route = this.route('update', {id: id});

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
    destroy (id) {
        return this.req(this.route('destroy', {id: id}), 'DELETE');
    }

    /**
     * Vote a comment.
     *
     * @param  {Number} id
     * @param  {Number} type
     * @return {Object}
     */
    vote (id, type) {
        return this.req(this.route('vote', {id: id}), 'POST', {type: type});
    }

    /**
     * Update settings.
     *
     * @param  {Array} settings
     * @return {Object}
     */
    updateSettings (settings) {
        return this.req(this.route('settings'), 'PUT', {settings: settings});
    }

    /**
     * Get the URL to a named route.
     *
     * @param  {String} name
     * @param  {Object} params
     * @return {String}
     */
    route (name, params) {
        let route = this.routes[name] || '';

        if (params) {
            for (let key in params) {
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
    req (route, type, data = {}) {
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
}

export default instance ? instance : new Api();
