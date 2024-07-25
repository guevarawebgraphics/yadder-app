import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}',
        'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#F6921E', // Primary color
                    dark: '#ee820c',    // Darker shade
                    light: '#faa546',   // Lighter shade
                },
                secondary: {
                    DEFAULT: '#ffed4a', // Secondary color
                    dark: '#f9d71c',    // Darker shade
                    light: '#fff7b0',   // Lighter shade
                },
                accent: {
                    DEFAULT: '#e3342f', // Accent color
                    dark: '#cc1f1a',    // Darker shade
                    light: '#ef5753',   // Lighter shade
                },
            },
        },
    },

    plugins: [forms, flowbite],
};
