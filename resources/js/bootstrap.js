/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const _useLocalPusher = Boolean(import.meta.env.VITE_PUSHER_HOST);

const _echoOptions = {
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
};

if (_useLocalPusher) {
    _echoOptions.wsHost = import.meta.env.VITE_PUSHER_HOST;
    _echoOptions.wsPort = import.meta.env.VITE_PUSHER_PORT;
    _echoOptions.wssPort = import.meta.env.VITE_PUSHER_PORT;
    _echoOptions.forceTLS = import.meta.env.VITE_PUSHER_SCHEME === 'https';
    _echoOptions.enabledTransports = ['ws', 'wss'];
    _echoOptions.disableStats = true; // don't call pusher.com stats endpoint
} else {
    _echoOptions.forceTLS = true;
}

window.Echo = new Echo(_echoOptions);
