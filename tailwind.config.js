import preset from './vendor/filament/support/tailwind.config.preset';

export default {
    presets: [preset],
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
        './vendor/filament/**/*.js',  // Ajoutez cette ligne
        './vendor/filament/**/*.vue', // Ajoutez cette ligne
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
