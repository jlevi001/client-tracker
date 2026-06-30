<div class="card-body bg-gradient-to-br from-base-200 to-base-300">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-bold">
        Welcome to your Jetstream application!
    </h1>

    <p class="mt-6 text-base-content/70 leading-relaxed">
        Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
        to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
        you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
        ecosystem to be a breath of fresh air. We hope you love it.
    </p>
</div>

<div class="bg-base-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 p-6 lg:p-8">
    <!-- Media Engine Section -->
    <div class="card bg-base-100 border border-secondary/40">
        <div class="card-body">
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-secondary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h2 class="card-title ml-3 text-secondary">
                    <a href="{{ url('/mediaengine') }}">Media Engine</a>
                </h2>
            </div>

            <p class="text-base-content/70 text-sm leading-relaxed">
                Lingo's blog and social-media engine that speeds up finding trending, on-brand content for clients and internal use — with built-in scheduling and automated posting.
            </p>

            <div class="card-actions justify-start mt-4">
                <a href="{{ url('/mediaengine') }}" class="btn btn-secondary btn-sm">
                    Open Media Engine
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-current">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Bulk Email Section -->
    <div class="card bg-base-100 border border-secondary/40">
        <div class="card-body">
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-secondary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                <h2 class="card-title ml-3 text-secondary">
                    Bulk Email
                </h2>
            </div>

            <p class="text-base-content/70 text-sm leading-relaxed">
                Send a branded bulk email to your contacts by tag (Prospects, Staff, Customers, Test, or everyone). It sends <strong>as you</strong> — replies come straight back to you — with personalization and one-click unsubscribe built in.
            </p>

            <div class="card-actions justify-start mt-4">
                <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('bulkEmailModal').showModal()">
                    Open Bulk Email
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-current">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Laracasts Section -->
    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-primary">
                    <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <h2 class="card-title ml-3">
                    <a href="https://laracasts.com">Laracasts</a>
                </h2>
            </div>

            <p class="text-base-content/70 text-sm leading-relaxed">
                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
            </p>

            <div class="card-actions justify-start mt-4">
                <a href="https://laracasts.com" class="btn btn-primary btn-sm">
                    Start watching Laracasts
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-current">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Tailwind Section -->
    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                <h2 class="card-title ml-3">
                    <a href="https://tailwindcss.com/">Tailwind</a>
                </h2>
            </div>

            <p class="text-base-content/70 text-sm leading-relaxed">
                Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that doesn't get in your way. You'll be amazed how easily you can build and maintain fresh, modern designs with this wonderful framework at your fingertips.
            </p>
        </div>
    </div>

    <!-- Authentication Section -->
    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <h2 class="card-title ml-3">
                    Authentication
                </h2>
            </div>

            <p class="text-base-content/70 text-sm leading-relaxed">
                Authentication and registration views are included with Laravel Jetstream, as well as support for user email verification and resetting forgotten passwords. So, you're free to get started with what matters most: building your application.
            </p>
        </div>
    </div>
</div>

{{-- Bulk Email modal: loads the self-contained emailer form in an isolated iframe.
     The iframe (/emailer/form) injects the logged-in user as the sender. --}}
<style>
    #bulkEmailModal{padding:0;border:none;background:transparent;max-width:none;max-height:none;}
    #bulkEmailModal::backdrop{background:rgba(0,0,0,.6);}
</style>
<dialog id="bulkEmailModal">
    <div style="position:relative;width:91vw;max-width:56rem;height:85vh;background:#0d1b2a;border-radius:12px;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,.55);">
        <form method="dialog" style="margin:0;">
            <button aria-label="Close" style="position:absolute;top:10px;right:10px;z-index:10;width:30px;height:30px;line-height:1;border-radius:9999px;border:none;background:rgba(0,0,0,.45);color:#fff;font-size:15px;cursor:pointer;">&times;</button>
        </form>
        <iframe src="{{ route('emailer.form') }}" title="Bulk Email" style="display:block;width:100%;height:100%;border:0;"></iframe>
    </div>
</dialog>