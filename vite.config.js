import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/inputCounterOne.js',
                'resources/js/inputCounterTwo.js',
                'resources/js/map.js',
                'resources/js/collapse.js',
                'resources/js/scroll.js',
            ],
            refresh: true,
        }),
    ],
});
