/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
import defaultTheme from 'tailwindcss/defaultTheme';

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      typography: ({ theme }) => ({
        white: {
          css: {
            '--tw-prose-body': theme('colors.white'),
            '--tw-prose-headings': theme('colors.white'),
            '--tw-prose-lead': theme('colors.white'),
            '--tw-prose-links': theme('colors.white'),
            '--tw-prose-bold': theme('colors.white'),
            '--tw-prose-counters': theme('colors.white'),
            '--tw-prose-bullets': theme('colors.white'),
            '--tw-prose-hr': theme('colors.white'),
            '--tw-prose-quotes': theme('colors.white'),
            '--tw-prose-quote-borders': theme('colors.white'),
            '--tw-prose-captions': theme('colors.white'),
            '--tw-prose-code': theme('colors.white'),
            '--tw-prose-pre-code': theme('colors.white'),
            '--tw-prose-pre-bg': theme('colors.white'),
            '--tw-prose-th-borders': theme('colors.white'),
            '--tw-prose-td-borders': theme('colors.white'),
            '--tw-prose-invert-body': theme('colors.white'),
            '--tw-prose-invert-headings': theme('colors.white'),
            '--tw-prose-invert-lead': theme('colors.white'),
            '--tw-prose-invert-links': theme('colors.white'),
            '--tw-prose-invert-bold': theme('colors.white'),
            '--tw-prose-invert-counters': theme('colors.white'),
            '--tw-prose-invert-bullets': theme('colors.white'),
            '--tw-prose-invert-hr': theme('colors.white'),
            '--tw-prose-invert-quotes': theme('colors.white'),
            '--tw-prose-invert-quote-borders': theme('colors.white'),
            '--tw-prose-invert-captions': theme('colors.white'),
            '--tw-prose-invert-code': theme('colors.white'),
            '--tw-prose-invert-pre-code': theme('colors.white'),
            '--tw-prose-invert-pre-bg': 'rgb(0 0 0 / 50%)',
            '--tw-prose-invert-th-borders': theme('colors.white'),
            '--tw-prose-invert-td-borders': theme('colors.white'),
          },
        },
      }),
      cursor: {
        'brand': 'url(hand.cur), auto',
      },
      fontFamily: {
        sans: ['Fira Sans', ...defaultTheme.fontFamily.sans],
        heading: ['Rubik', ...defaultTheme.fontFamily.sans],
      },
      backgroundImage: {
        'gradient': "linear-gradient(90deg, rgb(247, 110, 167), rgb(148, 232, 245))",
        'gradient-radial': "radial-gradient(rgb(247, 110, 167), rgb(148, 232, 245))",
        'gradient-alist': "linear-gradient(90deg, rgb(137, 56, 174), rgb(240, 29, 45))",
        'gradient-alistcore': "linear-gradient(90deg,rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%)",
      },
      colors: {
        gray: colors.neutral,
        brand: 'rgb(247, 110, 167)',
        'brand-dark': 'rgb(186, 60, 113)',
        'brand-light': 'rgb(255 236 244)',
        'brand-alist': 'rgb(186, 37, 109)'
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms')
  ],
}