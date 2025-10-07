import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss({
      config: {
        content: [
          "./resources/views/**/*.blade.php",
          "./resources/js/**/*.js",
          "./resources/css/**/*.css",
        ],
        theme: {
          extend: {
            colors: {
              midnight_green: {
                DEFAULT: '#074B61',
                100: '#010f13',
                200: '#031d26',
                300: '#042c39',
                400: '#053b4c',
                500: '#074B61',
                600: '#0c84ac',
                700: '#1abaef',
                800: '#66d1f4',
                900: '#b3e8fa',
              },
              ecru: {
                DEFAULT: '#D5C78C',
                100: '#332d13',
                200: '#675a26',
                300: '#9a8739',
                400: '#c1ac58',
                500: '#D5C78C',
                600: '#ddd1a3',
                700: '#e5ddba',
                800: '#eee8d1',
                900: '#f6f4e8',
              },
            },
          },
        },
        plugins: [],
      },
    }),
    ],
});
