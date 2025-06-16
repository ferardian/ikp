import { defineConfig } from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/pdf.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
                'resources/**/*.blade.php',
                'resources/views/**/*.blade.php',
            ],
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name == 'pdf.css') {
                        return 'assets/[name][extname]';
                    }

                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
});
