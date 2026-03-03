/** @type {import('tailwindcss').Config} */
export default {
  // Scans all PHP, HTML, and JS files for class names
  content: [
    './*.php',
    './includes/**/*.php',
    './_admin_site/**/*.php',
    './dist/js/**/*.js',
  ],

  // Class-based dark mode (controlled via <html class="dark">)
  darkMode: 'class',

  theme: {
    extend: {
      colors: {
        // --- Primary (Violet tech) ---
        primary: {
          DEFAULT: '#5A31F4',
          glow:    '#7B5EF8',
          hover:   '#4A24E8',
          active:  '#3A18CC',
          dark:    '#7B5EF8',
        },
        // --- Secondary (Cyan tech) ---
        secondary: {
          DEFAULT: '#0EA5E9',
          dark:    '#38BDF8',
        },
        // --- Accent CTA (Rouge conversion) ---
        accent: {
          DEFAULT: '#F43F5E',
          dark:    '#FB7185',
        },
        // --- Backgrounds ---
        bg: {
          base:        '#F8F7FF',
          alt:         '#EEF0F8',
          'base-dark': '#0D0B1A',
          'alt-dark':  '#13111F',
        },
        // --- Surfaces (cards, modals) ---
        surface: {
          DEFAULT:       '#FFFFFF',
          raised:        '#F0EFFE',
          dark:          '#1C1930',
          'raised-dark': '#231E3A',
        },
        // --- Borders ---
        border: {
          DEFAULT: '#E0DEFF',
          dark:    '#2E2752',
        },
        // --- Textes ---
        text: {
          primary:         '#120B2E',
          secondary:       '#6B6589',
          disabled:        '#B0AABB',
          'primary-dark':  '#EDE9FF',
          'secondary-dark':'#9B96BB',
        },
        // --- États sémantiques ---
        success: { DEFAULT: '#10B981', dark: '#34D399' },
        warning: { DEFAULT: '#F59E0B', dark: '#FCD34D' },
        error:   { DEFAULT: '#EF4444', dark: '#F87171' },
        info:    { DEFAULT: '#0EA5E9', dark: '#38BDF8' },
      },

      // --- Typographie ---
      fontFamily: {
        sans: ['Inter Variable', 'Inter', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
      },

      // --- Font sizes fluides ---
      fontSize: {
        'fluid-sm':  ['clamp(0.875rem, 0.8rem + 0.375vw, 1rem)', { lineHeight: '1.5' }],
        'fluid-base':['clamp(1rem, 0.9rem + 0.5vw, 1.125rem)',   { lineHeight: '1.6' }],
        'fluid-lg':  ['clamp(1.125rem, 1rem + 0.625vw, 1.375rem)',{ lineHeight: '1.5' }],
        'fluid-xl':  ['clamp(1.25rem, 1rem + 1.25vw, 1.75rem)',  { lineHeight: '1.4' }],
        'fluid-2xl': ['clamp(1.5rem, 1rem + 2.5vw, 2.25rem)',    { lineHeight: '1.3' }],
        'fluid-3xl': ['clamp(1.875rem, 1rem + 4.375vw, 3rem)',   { lineHeight: '1.25' }],
        'fluid-4xl': ['clamp(2.25rem, 1rem + 6.25vw, 3.75rem)',  { lineHeight: '1.2' }],
      },

      // --- Shadows premium ---
      boxShadow: {
        'glow-sm':    '0 0 12px rgba(90, 49, 244, 0.25)',
        'glow':       '0 0 24px rgba(90, 49, 244, 0.35)',
        'glow-lg':    '0 0 48px rgba(90, 49, 244, 0.45)',
        'soft':       '0 4px 24px rgba(18, 11, 46, 0.08)',
        'soft-lg':    '0 8px 40px rgba(18, 11, 46, 0.12)',
        'card':       '0 2px 12px rgba(90, 49, 244, 0.08), 0 1px 3px rgba(18, 11, 46, 0.05)',
        'card-hover': '0 8px 32px rgba(90, 49, 244, 0.18), 0 2px 8px rgba(18, 11, 46, 0.08)',
      },

      // --- Border radius étendus ---
      borderRadius: {
        'xl2': '1rem',
        'xl3': '1.5rem',
        'xl4': '2rem',
      },

      // --- Gradients ---
      backgroundImage: {
        'gradient-primary':  'linear-gradient(135deg, #5A31F4 0%, #0EA5E9 100%)',
        'gradient-dark':     'linear-gradient(135deg, #3A18CC 0%, #0891B2 100%)',
        'gradient-glow':     'radial-gradient(ellipse at 50% 0%, rgba(90, 49, 244, 0.15) 0%, transparent 70%)',
        'gradient-card':     'linear-gradient(180deg, rgba(90, 49, 244, 0.04) 0%, transparent 100%)',
      },

      // --- Transitions ---
      transitionDuration: {
        '250': '250ms',
        '350': '350ms',
        '400': '400ms',
      },

      // --- Animations ---
      keyframes: {
        'fade-in': {
          '0%':   { opacity: '0', transform: 'translateY(8px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        'slide-in-right': {
          '0%':   { opacity: '0', transform: 'translateX(16px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        'bounce-in': {
          '0%':   { transform: 'scale(0.9)', opacity: '0' },
          '70%':  { transform: 'scale(1.05)' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        'glow-pulse': {
          '0%, 100%': { boxShadow: '0 0 12px rgba(90, 49, 244, 0.2)' },
          '50%':      { boxShadow: '0 0 28px rgba(90, 49, 244, 0.5)' },
        },
        'scroll-infinite': {
          '0%':   { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' },
        },
      },
      animation: {
        'fade-in':        'fade-in 0.3s ease-out both',
        'slide-in-right': 'slide-in-right 0.3s ease-out both',
        'bounce-in':      'bounce-in 0.4s ease-out both',
        'glow-pulse':     'glow-pulse 2s ease-in-out infinite',
        'scroll-infinite':'scroll-infinite 25s linear infinite',
      },
    },
  },

  plugins: [],
};
