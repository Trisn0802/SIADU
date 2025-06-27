import './bootstrap';
import Echo from "laravel-echo";
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY, // atau VITE_PUSHER_APP_KEY jika pakai Vite
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});
