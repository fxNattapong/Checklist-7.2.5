import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import VitePluginBrowserSync from 'vite-plugin-browser-sync'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        VitePluginBrowserSync({
            bs: {
                ui: {
                port: 8080
                },
                notify: false
            }
        })
    ],
});
