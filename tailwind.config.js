const defaultTheme = require('tailwindcss/defaultTheme');

/**
 * @type {import('tailwindcss').Config} 
 */
module.exports = {
    darkMode: 'dark',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                mono: ['ui-monospace', 'SFMono-Regular'],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
