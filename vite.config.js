import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import viteWebfontDownload from 'vite-plugin-webfont-dl';
import mjml from 'vite-plugin-mjml'

export default defineConfig({
    hmr: {
        host: 'summerdreams',
    },
    plugins: [
        viteWebfontDownload([
            'https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
            'https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap',
        ]),
        mjml({
            input: 'resources/mail/mjml',
            output: 'resources/views/mail',
            extension: '.blade.php',
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true
        }),
    ],
});
