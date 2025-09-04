// tailwind.config.js
const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');
const typography = require('@tailwindcss/typography');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './app/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    forms, 
    typography, 
    require('daisyui')
  ],
  // Configure daisyUI with custom dark theme
  daisyui: {
    themes: [
      {
        dark: {
          "primary": "#6366f1",          // Indigo-600
          "primary-focus": "#4f46e5",    // Indigo-700
          "primary-content": "#ffffff",   // White text on primary
          
          "secondary": "#8b5cf6",         // Purple-600
          "secondary-focus": "#7c3aed",  // Purple-700
          "secondary-content": "#ffffff", // White text on secondary
          
          "accent": "#10b981",            // Green-600
          "accent-focus": "#059669",      // Green-700
          "accent-content": "#ffffff",    // White text on accent
          
          "neutral": "#374151",           // Gray-700
          "neutral-focus": "#1f2937",     // Gray-800
          "neutral-content": "#ffffff",   // White text on neutral
          
          "base-100": "#1f2937",          // Gray-800 (main background)
          "base-200": "#111827",          // Gray-900 (darker background)
          "base-300": "#0f172a",          // Gray-950 (darkest)
          "base-content": "#f3f4f6",      // Gray-100 (main text color)
          
          "info": "#3b82f6",              // Blue-500
          "info-content": "#ffffff",       // White text on info
          
          "success": "#10b981",           // Green-500
          "success-content": "#ffffff",    // White text on success
          
          "warning": "#f59e0b",           // Amber-500
          "warning-content": "#000000",    // Black text on warning
          
          "error": "#ef4444",             // Red-500
          "error-content": "#ffffff",      // White text on error

          // Additional semantic colors
          "--rounded-box": "0.5rem",      // border radius for cards and boxes
          "--rounded-btn": "0.375rem",    // border radius for buttons
          "--rounded-badge": "1.9rem",    // border radius for badges
          "--animation-btn": "0.25s",     // button click animation
          "--animation-input": "0.2s",    // input animation
          "--btn-text-case": "none",      // don't uppercase button text
          "--navbar-padding": "0.5rem",   // navbar padding
          "--border-btn": "1px",          // button border width
        }
      },
      "light", // Include default light theme for future use
    ],
    darkTheme: "dark", // Set dark as default theme
    base: true,        // Apply base styles
    styled: true,      // Include daisyUI component styles
    utils: true,       // Include utility classes
    logs: false,       // Disable logs in production
  },
};