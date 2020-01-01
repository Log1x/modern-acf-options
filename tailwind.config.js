module.exports = {
  theme: {
    extend: {
      colors: {
        brand: 'var(--acf-brand, #0073aa)',
        trim: 'var(--acf-trim, #191919)',
        current: 'currentColor',
      },

      spacing: {
        '38': '9.5rem'
      },

      textShadow: {
        default: '0 2px 5px rgba(0, 0, 0, 0.5)',
        none: 'none'
      },

      borderStyles: {
        colors: true,
      },

      animations: {
        'spin': {
          from: { transform: 'rotate(0deg)' },
          to: { transform: 'rotate(360deg)' },
        },
      },

      spinner: theme => ({
        default: {
          color: theme('colors.gray.300'),
          size: '1.5rem',
          border: '0.15rem',
          speed: '750ms'
        }
      })
    }
  },
  variants: {},
  plugins: [
    require('tailwindcss-spinner')(),
    require('tailwindcss-typography')(),
    require('tailwindcss-animations')(),
    require('tailwindcss-border-styles')(),

    ({ addUtilities }) => {
      addUtilities({
        '.bg-none': {
          'background-image': 'none',
        },
        '.empty': {
          'content': `''`,
        },
        '.subtitle': {
          'content': 'var(--acf-subtitle, \'Theme Options\')',
        },
      });
    },
  ]
};
