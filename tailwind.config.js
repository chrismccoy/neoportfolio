/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        neo: {
          yellow: '#FFDE59',
          pink: '#FF90E8',
          cyan: '#5CE1E6',
          red: '#FF4D4D',
          green: '#90EE90',
          black: '#000000',
          white: '#ffffff',
        },
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
      },
      boxShadow: {
        'neo-sm':  '2px 2px 0 0 var(--tw-shadow-color, #000)',
        'neo':     '4px 4px 0 0 var(--tw-shadow-color, #000)',
        'neo-md':  '6px 6px 0 0 var(--tw-shadow-color, #000)',
        'neo-lg':  '8px 8px 0 0 var(--tw-shadow-color, #000)',
        'neo-xl':  '10px 10px 0 0 var(--tw-shadow-color, #000)',
        'neo-2xl': '16px 16px 0 0 var(--tw-shadow-color, #000)',
        'neo-3xl': '20px 20px 0 0 var(--tw-shadow-color, #000)',
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            '--tw-prose-body': theme('colors.neo.black'),
            '--tw-prose-headings': theme('colors.neo.black'),
            '--tw-prose-links': theme('colors.neo.black'),
            '--tw-prose-bold': theme('colors.neo.black'),
            '--tw-prose-counters': theme('colors.neo.black'),
            '--tw-prose-bullets': theme('colors.neo.black'),
            '--tw-prose-quotes': theme('colors.neo.black'),
            maxWidth: 'none',
            h1: {
              fontWeight: '900',
              textTransform: 'uppercase',
              borderBottomWidth: '4px',
              borderBottomColor: theme('colors.neo.black'),
              paddingBottom: '0.5rem',
              marginBottom: '1.5rem',
            },
            h2: {
              fontWeight: '900',
              textTransform: 'uppercase',
              borderBottomWidth: '4px',
              borderBottomColor: theme('colors.neo.black'),
              paddingBottom: '0.5rem',
              marginTop: '2rem',
              marginBottom: '1rem',
            },
            h3: {
              fontWeight: '800',
              textTransform: 'uppercase',
            },
            p: {
              fontWeight: '500',
              lineHeight: '1.75',
              marginBottom: '1.5rem',
            },
            'blockquote p:first-of-type::before': { content: 'none' },
            'blockquote p:last-of-type::after': { content: 'none' },
            blockquote: {
              fontWeight: '900',
              fontStyle: 'normal',
              borderLeftWidth: '12px',
              borderLeftColor: theme('colors.neo.pink'),
              backgroundColor: theme('colors.neutral.50'),
              borderTopWidth: '4px',
              borderRightWidth: '4px',
              borderBottomWidth: '4px',
              borderColor: theme('colors.neo.black'),
              padding: '2rem',
              boxShadow: '8px 8px 0 0 #000',
            },
            a: {
              backgroundColor: theme('colors.neo.cyan'),
              textDecoration: 'none',
              borderWidth: '2px',
              borderColor: theme('colors.neo.black'),
              padding: '0 0.25rem',
              fontWeight: '700',
              display: 'inline-block',
              transition: 'all 0.1s ease-in-out',
              '&:hover': {
                 boxShadow: '4px 4px 0 0 #000',
                 transform: 'translate(-2px, -2px)',
                 backgroundColor: theme('colors.neo.white'),
              }
            },
            img: {
              borderWidth: '4px',
              borderColor: theme('colors.neo.black'),
              boxShadow: '8px 8px 0 0 #000',
              marginTop: '2rem',
              marginBottom: '2rem',
            },
            pre: {
              backgroundColor: theme('colors.neo.black'),
              color: theme('colors.neo.white'),
              borderWidth: '4px',
              borderColor: theme('colors.neo.pink'),
              boxShadow: '6px 6px 0 0 #5CE1E6',
            },
            code: {
               fontFamily: theme('fontFamily.mono').join(','),
               fontWeight: '700',
            }
          },
        },
      }),
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
};
