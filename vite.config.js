import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
        tailwindcss(),
    ],
    server: {
        host: '192.168.1.19',
        port: 5173, // ini port Vite (frontend hot reload)
        hmr: {
            host: '192.168.1.19',
        },
    },
});
