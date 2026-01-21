import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'socket.io',
    // host: window.location.hostname + ":" + window.laravel_echo_port
    host: 'https://neopaed.sks.net.in:' + window.laravel_echo_port
});