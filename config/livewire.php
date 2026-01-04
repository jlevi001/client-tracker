<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    */
    'class_namespace' => 'App\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    */
    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */
    'layout' => 'layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Configure temporary file upload settings. Livewire handles file uploads
    | by storing uploads in a temporary directory, then moving them when
    | the form is submitted.
    |
    */
    'temporary_file_upload' => [
        'disk' => 'local',           // Use local disk
        'rules' => ['required', 'file', 'max:5120'], // 5MB max
        'directory' => 'livewire-tmp',  // Directory within storage/app
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,    // Max 5 minutes for upload
        'cleanup' => true,          // Cleanup temp files
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigate (SPA Mode)
    |--------------------------------------------------------------------------
    */
    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#6366f1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Theme
    |--------------------------------------------------------------------------
    */
    'pagination_theme' => 'tailwind',

];