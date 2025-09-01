<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lingo Client Tracker UI Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all the standardized UI classes and configurations
    | for maintaining a consistent dark theme design system throughout the
    | application. Use these classes via config('ui.classes.input') etc.
    |
    */

    'theme' => 'dark',

    'colors' => [
        'backgrounds' => [
            'main' => 'bg-gray-900',
            'card' => 'bg-gray-800', 
            'modal' => 'bg-gray-800',
            'input' => 'bg-gray-700',
            'hover' => 'bg-gray-600',
            'footer' => 'bg-gray-900',
        ],
        'text' => [
            'primary' => 'text-white',
            'secondary' => 'text-gray-300',
            'muted' => 'text-gray-400',
            'label' => 'text-gray-300',
            'placeholder' => 'placeholder-gray-400',
            'error' => 'text-red-400',
            'success' => 'text-green-400',
        ],
        'borders' => [
            'default' => 'border-gray-600',
            'divider' => 'border-gray-700',
            'focus' => 'border-indigo-500',
            'error' => 'border-red-500',
        ],
        'accents' => [
            'primary' => 'indigo-600',
            'success' => 'green-600',
            'danger' => 'red-600',
            'warning' => 'yellow-600',
            'info' => 'blue-600',
        ],
    ],

    'classes' => [
        // Form Inputs
        'input' => 'w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200',
        
        'input_error' => 'w-full px-3 py-2 bg-gray-700 border border-red-500 rounded-md text-white placeholder-gray-400 focus:bg-gray-600 focus:border-red-500 focus:ring-1 focus:ring-red-500 hover:bg-gray-600 transition-colors duration-200',
        
        'select' => 'w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200',
        
        'textarea' => 'w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200',
        
        'checkbox' => 'rounded bg-gray-700 border-gray-600 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-800',
        
        'radio' => 'bg-gray-700 border-gray-600 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-800',
        
        'label' => 'block text-sm font-medium text-gray-300 mb-2',
        
        // Buttons
        'button_primary' => 'px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200',
        
        'button_secondary' => 'px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200',
        
        'button_success' => 'px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200',
        
        'button_danger' => 'px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200',
        
        'button_warning' => 'px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200',
        
        'button_info' => 'px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200',
        
        'button_text' => 'text-indigo-400 hover:text-indigo-300 focus:outline-none focus:underline transition-colors duration-200',
        
        'button_icon' => 'p-2 text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded-md transition-colors duration-200',
        
        // Cards & Containers
        'card' => 'bg-gray-800 rounded-lg border border-gray-700 p-6',
        
        'modal_container' => 'bg-gray-800 rounded-lg',
        
        'modal_header' => 'px-6 py-4 border-b border-gray-700',
        
        'modal_body' => 'px-6 py-4 space-y-6 max-h-[70vh] overflow-y-auto',
        
        'modal_footer' => 'px-6 py-4 bg-gray-900 border-t border-gray-700 flex justify-end space-x-3 rounded-b-lg',
        
        // Tables
        'table_container' => 'overflow-x-auto',
        
        'table' => 'min-w-full divide-y divide-gray-700',
        
        'table_header' => 'bg-gray-800',
        
        'table_header_cell' => 'px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider',
        
        'table_body' => 'bg-gray-900 divide-y divide-gray-700',
        
        'table_row' => 'hover:bg-gray-800',
        
        'table_cell' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-300',
        
        // Alerts
        'alert_success' => 'p-4 bg-green-900 border border-green-700 text-green-300 rounded-lg',
        
        'alert_error' => 'p-4 bg-red-900 border border-red-700 text-red-300 rounded-lg',
        
        'alert_warning' => 'p-4 bg-yellow-900 border border-yellow-700 text-yellow-300 rounded-lg',
        
        'alert_info' => 'p-4 bg-blue-900 border border-blue-700 text-blue-300 rounded-lg',
        
        // Information Display
        'info_box' => 'p-4 bg-gray-700 border border-gray-600 rounded-lg',
        
        'stat_card' => 'bg-gray-800 p-6 rounded-lg border border-gray-700',
        
        // File Upload
        'file_upload' => 'flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 border-dashed rounded-lg bg-gray-700 hover:bg-gray-600 hover:border-gray-500 transition-colors duration-200 cursor-pointer',
        
        // Form Groups
        'form_group' => 'space-y-4',
        
        'form_section' => 'pt-6 border-t border-gray-700',
        
        // Loading States
        'loading_overlay' => 'opacity-50 pointer-events-none',
        
        'loading_spinner' => 'animate-spin h-5 w-5 text-indigo-500',
    ],

    'spacing' => [
        'form_fields' => 'space-y-4',
        'sections' => 'space-y-6',
        'section_padding' => 'p-6',
        'compact_padding' => 'p-4',
        'button_group' => 'space-x-3',
        'label_margin' => 'mb-2',
        'header_margin' => 'mb-4',
    ],

    'breakpoints' => [
        'mobile' => '375px',
        'tablet' => '768px',
        'desktop' => '1024px',
        'wide' => '1920px',
    ],

    'transitions' => [
        'default' => 'transition-colors duration-200',
        'all' => 'transition-all duration-200',
        'fast' => 'transition-all duration-150',
        'slow' => 'transition-all duration-300',
    ],

    'z_index' => [
        'dropdown' => 'z-10',
        'modal' => 'z-50',
        'notification' => 'z-40',
        'tooltip' => 'z-30',
    ],
];