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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Fredoka', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: '#14301F',
                brand: '#2F9E5C',
                'brand-soft': '#E3F5E9',
                lime: '#D7E539',
                paper: '#FBF6EA',
                border: '#E6DFC8',
                role: {
                    mahasiswa: '#E0A100',
                    'mahasiswa-soft': '#FFF3D6',
                    dosen: '#035A35',
                    'dosen-soft': '#E3F5E9',
                    panitia: '#ED4120',
        'panitia-soft': '#FDE3DC',
        admin: '#4FA0F4',
        'admin-soft': '#E7F2FE',
    },
    accent: {
        yellow: '#FFCA26',
        tomato: '#ED4120',
        carrot: '#F86015',
        kiwi: '#9ABC04',
    },
},
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
        },
    },

    plugins: [forms],
};