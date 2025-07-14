import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js',
                'resources/js/gameboard.js',
                'resources/css/GameBoard.module.scss',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
