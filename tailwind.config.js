import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php",
    "./vendor/wireui/wireui/src/*.php",
    "./vendor/wireui/wireui/ts/**/*.ts",
    "./vendor/wireui/wireui/src/WireUi/**/*.php",
    "./vendor/wireui/wireui/src/Components/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: colors.violet,
        secondary: colors.slate,
        positive: colors.emerald,
        negative: colors.red,
        warning: colors.amber,
        info: colors.blue,
        background: {
          white: colors.white,
          dark: colors.slate[800],
        },
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('./vendor/wireui/wireui/ts/tailwindcss/plugins/form/validation'),
    require('./vendor/wireui/wireui/ts/tailwindcss/plugins/form/input-state'),
    require('./vendor/wireui/wireui/ts/tailwindcss/plugins/hideScrollbar'),
    require('./vendor/wireui/wireui/ts/tailwindcss/plugins/softScrollbar'),
    require('./vendor/wireui/wireui/ts/tailwindcss/plugins/appearance-none'),
  ],
}
