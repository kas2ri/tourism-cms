/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        serif: ['"Cormorant Garamond"', 'serif'],
        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
      },
      colors: {
        primary: 'var(--color-primary, #1a3b32)',
        secondary: 'var(--color-secondary, #c86d51)',
        forest: {
          800: '#142f28',
          900: '#0e231e',
          DEFAULT: 'var(--color-primary, #1a3b32)',
          light: '#285448'
        },
        terracotta: {
          DEFAULT: 'var(--color-secondary, #c86d51)',
          dark: '#af563c',
          light: '#df8970'
        },
        sand: {
          50: 'var(--color-bg-sand, #f4efe6)',
          100: '#f4efe6',
          200: '#e8dcce',
          DEFAULT: '#e3d2be',
          dark: '#c4ad93'
        },
        gold: '#d4af37'
      }
    },
  },
  plugins: [],
}
