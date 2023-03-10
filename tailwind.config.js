const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue"
  ],
  theme: {
    extend: {
        colors: {
            primary: colors.blue,
            secondary: colors.gray,
        },
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
