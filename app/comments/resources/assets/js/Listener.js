class Listener {
    /**
     * Create a new instance.
     *
     * @param {String} channel
     * @param {Object} config
     */
    constructor (channel, config) {
        this.channel = channel;
        this.driver  = config.driver;
        this.instance = this.createDriver(config);
    }

    /**
     * Listen for events.
     *
     * @param  {String}   event
     * @param  {Function} callback
     * @return {Object}
     */
    on (event, callback) {
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
    createDriver (config) {
        switch (config.driver) {
        case 'pusher':
            return new Pusher(config.pusherKey);

        case 'redis':
            return io(config.socket);
        }
    }
}

export default Listener;
