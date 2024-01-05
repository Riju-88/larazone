const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');
const daisyui = require('daisyui');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      backgroundImage: theme => ({
        'lime': 'linear-gradient(126deg, rgba(16, 131, 43, 1) 0%, rgba(83, 189, 22, 1) 90%)',
        'pro': 'linear-gradient(180deg, #e9e2a1 0%, #d1a24f 50%, #9b8227 51%, #d48506 100%)',
        'user': 'linear-gradient(0deg, rgba(10, 86, 252, 0.404)50%, rgba(36, 110, 248, 0.884)100%)',
        'admin': 'linear-gradient(0deg,rgba(110, 13, 236, 0.322)50%, rgba(113, 12, 245, 0.616)75%, rgba(133, 10, 233, 0.952)100%)',
        'mod': 'linear-gradient(0deg,rgba(236, 65, 13, 0.322)50%, rgba(245, 66, 12, 0.616)75%, rgba(233, 81, 10, 0.952)100%)',
        'newUser': 'linear-gradient(0deg,rgba(63, 214, 3, 0.301)50%, rgba(10, 223, 20, 0.9)100%)',
        'troll': 'linear-gradient(0deg,rgba(253, 22, 99, 0.5)50%, rgba(211, 7, 24, 0.9)100%)',
      })
    },
  },

  

  daisyui: {
    themes: [
      {
        mytheme: {
          "primary": "#fc0b53",
          "secondary": "#e6e6e6",
          "accent": "#2f2f2f",
          "neutral": "#21252b",
          "base-100": "#101214",
          // "base-100": "#1b1d22",
          "info": "#1055ff",
          "success": "#16a34a",
          "warning": "#f8c930",
          "error": "red",
        },
         container: {
        center: true,
      },
      },
    ],
  },

  plugins: [forms, daisyui],
};
