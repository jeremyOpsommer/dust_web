import preset from './vendor/filament/support/tailwind.config.preset';

export default {
    presets: [preset],
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
        './app/Http/Controllers/**/*.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                // Ajoutez vos couleurs personnalisées ici
                gray: {
                    900: '#111827', // Exemple de redéfinition de la couleur manquante
                    800: '#1f2937',
                    700: '#374151',
                    // Ajoutez d'autres nuances de gris si nécessaire
                },
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
                // Ajoutez d'autres couleurs personnalisées ici
                accent: '#ff5722',
            },
        },
    },
    plugins: [],
};
