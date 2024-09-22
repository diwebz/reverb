import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // This allows access from outside the Vagrant box
        port: 5173,
        hmr: {
            host: 'reverb.test', // Your local development domain
            // host: '0701-217-178-54-242.ngrok-free.app', // Your local development domain(this is for while runnig ngrok)
            protocol: 'ws', // Ensure WebSocket is used for HMR
            // protocol: 'wss', // Ensure WebSocket is used for HMR(this is for while runnig ngrok)
            port: 5173,
        },
        watch: {
            usePolling: true, // Useful in virtualized environments
        },
        open: false, //open browser not supported in my envioronment
        strictPort: true,
        https: false,
    }
});
