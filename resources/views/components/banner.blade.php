@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

<div x-data="{{ json_encode(['show' => true, 'style' => $style, 'message' => $message]) }}"
    :class="{ 
        'alert-success': style == 'success', 
        'alert-error': style == 'danger', 
        'alert-warning': style == 'warning', 
        'alert-info': style != 'success' && style != 'danger' && style != 'warning'
    }"
    style="display: none;"
    x-show="show && message"
    x-on:banner-message.window="
        style = event.detail.style;
        message = event.detail.message;
        show = true;
    "
    class="alert">
    
    <div class="flex items-center w-full">
        <!-- Icon -->
        <svg x-show="style == 'success'" class="stroke-current shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        
        <svg x-show="style == 'danger'" class="stroke-current shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg>
        
        <svg x-show="style == 'warning'" class="stroke-current shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4v.01 0 0 " />
        </svg>
        
        <svg x-show="style != 'success' && style != 'danger' && style != 'warning'" class="stroke-current shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        
        <!-- Message -->
        <span class="flex-1 ms-3" x-text="message"></span>
        
        <!-- Close Button -->
        <button
            type="button"
            class="btn btn-ghost btn-sm btn-circle"
            aria-label="Dismiss"
            x-on:click="show = false">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>