import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'school-background': "url('public/assets/image/plm.png')",
            },
            height: {
                "10v": "10vh",
                "20v": "20vh",
                "30v": "30vh",
                "40v": "40vh",
                "50v": "50vh",
                "60v": "60vh",
                "70v": "70vh",
                "80v": "80vh",
                "85v": "85vh",
                "90v": "90vh",
                "100v": "100vh",
            },
            width: {
                "10v": "10vw",
                "14v": "14vw",
                "15v": "15vw",
                "20v": "20vw",
                "30v": "30vw",
                "40v": "40vw",
                "50v": "50vw",
                "60v": "60vw",
                "70v": "70vw",
                "80v": "80vw",
                "90v": "90vw",
                "100v": "100vw",
            },
        },
    },

    plugins: [
        forms,
        require('tailwind-scrollbar')
    ],
};
