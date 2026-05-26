import { defineConfig } from 'vite'
import vue from "@vitejs/plugin-vue";
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import path from 'path'

export default defineConfig({
    resolve: {
        alias: {
            'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
            '@': path.resolve('resources/js'),
        },
    },
    plugins: [
        vue(),
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: [
                ...refreshPaths,
                'app/Filament/**',
                'app/Forms/Components/**',
                'app/Livewire/**',
                'app/Infolists/Components/**',
                'app/Providers/Filament/**',
                'app/Tables/Columns/**',
            ],
        }),
    ],
})
