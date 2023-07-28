import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#0C2E8A",
                primary2: " #546CAD",
            },
            backgroundImage: {
                'home-img': "url('./img/home.webp')",
            },
            fontFamily: {
                'roboto': ['Roboto', 'sans-serif']
            }
        },
    },

    plugins: [forms],
};
