module.exports = {
    proxy: {
        target: 'http://learning-wordpress.local',
        ws: true,
    },

    files: ['wp-content/themes/**/*.{php,css,js}', 'wp-content/plugins/**/*.{php,css,js}'],

    watchOptions: {
        ignoreInitial: true,
        usePolling: true,
        interval: 1000,
    },

    injectChanges: true,
    reloadDelay: 500,
    reloadDebounce: 1000,

    open: true,
    notify: true,
    ghostMode: false,
    port: 3000,
    ui: false,
    logLevel: 'debug',
};
