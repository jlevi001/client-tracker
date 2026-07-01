# Embedding Standalone HTML Forms in Modals (reusable pattern)

_Added 2026-06-29. First implemented for the **Bulk Email** tool on the dashboard._

This is the house pattern for dropping a **self-contained HTML tool/form** into the app — behind login, in a pop-up modal — **without** rewriting it as Blade/Livewire/daisyUI. Use it whenever you have (or want) a single standalone `.html` file that's easier to maintain on its own than to port into the component system.

## When to use this (vs. a native Livewire build)

Use this pattern when:
- You already have a working standalone HTML form/tool (often one that posts to an n8n webhook or external API).
- You want it to stay a **single editable HTML file** — quick to tweak, no build step, no Blade/Livewire refactor.
- It only needs the logged-in user's context injected (name/email/role/etc.).

Build it natively as a **Livewire component** instead (see `MediaEngine`) when it needs deep, reactive integration with app data/models, server round-trips per interaction, or must visually match daisyUI exactly inside the page (not in aframed box).

## Architecture — three pieces

```
Dashboard card (daisyUI button)
        │  onclick → showModal()
        ▼
<dialog> modal (self-styled, inline CSS)
        │  contains
        ▼
<iframe src="/yourtool/form">  ◄── isolates the form's own CSS from the app
        │  loads
        ▼
Auth-gated route  →  reads resources/yourtool/form.html
                     injects window.* context before </head>
                     returns the HTML
```

1. **The HTML file** — lives in `resources/<tool>/<tool>.html` (NOT in `public/`, which would bypass auth). Self-contained: its own `<style>` and `<script>`. Reads injected globals (e.g. `window.LINGO_SENDER`) for per-user context.
2. **An auth-gated route** — `GET /<tool>/form` inside the `auth:sanctum` group. Reads the file, injects server-side context as a `<script>` before `</head>`, returns it with `X-Frame-Options: SAMEORIGIN`.
3. **A launcher + modal** — a daisyUI card/button on the dashboard (or wherever) that opens a `<dialog>` modal containing an `<iframe>` pointing at the route.

---

## Reference implementation: the Bulk Email tool

### 1. The form — `resources/emailer/emailer.html`
A normal standalone HTML page. Two things make it "app-aware":

```html
<!-- It reads context the route injects just before </head>: -->
<script>
  // window.LINGO_SENDER  = { email, name }  (the logged-in user)
  // window.LINGO_SENDERS = [{ email, name }, ...]  (pickable options)
  const SENDERS = Array.isArray(window.LINGO_SENDERS) ? window.LINGO_SENDERS : [];
  const DEFAULT_SENDER = (window.LINGO_SENDER && window.LINGO_SENDER.email)
    ? window.LINGO_SENDER : (SENDERS[0] || { email: '', name: '' });
  // ...populate a <select>, default to the logged-in user, etc.
</script>
```

The form posts directly to its n8n webhook (the webhook is open/internal, so there's no secret to hide). Edit this one file anytime — no build, no recompile.

**Body editor (WYSIWYG).** The message body is a `contenteditable` div driven by a tiny `format(cmd, val)` helper that just calls `document.execCommand(cmd, ...)`. The toolbar exposes: Paragraph/H1–H3, **Bold/Italic/Underline**, bullet & numbered lists, **Left/Center/Right alignment** (`justifyLeft`/`justifyCenter`/`justifyRight`, added 2026-07-01), Link, and Clear. `execCommand` writes **inline styles** (e.g. `text-align:center`) onto the block, and the body is sent as `editor.innerHTML`, so all formatting — alignment included — survives into the delivered email. To add another button, add a `<button ... onclick="format('<execCommand>')">` in `.toolbar`; no other wiring is needed.

### 2. The route — `routes/web.php` (inside the `auth:sanctum` group)

```php
Route::get('/emailer/form', function () {
    $html = file_get_contents(resource_path('emailer/emailer.html'));

    // Default context = the logged-in user.
    $me = json_encode([
        'email' => auth()->user()->email,
        'name'  => auth()->user()->name,
    ], JSON_UNESCAPED_SLASHES);

    // Optional list context (here: active @lingoit.net teammates to "send as").
    $senders = \App\Models\User::orderBy('name')
        ->get(['name', 'email', 'employment_end_date'])
        ->filter(fn ($u) => $u->is_active
            && str_ends_with(strtolower((string) $u->email), '@lingoit.net'))
        ->map(fn ($u) => ['email' => $u->email, 'name' => $u->name])
        ->values()
        ->toJson(JSON_UNESCAPED_SLASHES);

    // Inject context just before </head>, then serve.
    $html = str_replace(
        '</head>',
        '<script>window.LINGO_SENDER = ' . $me . '; window.LINGO_SENDERS = ' . $senders . ';</script></head>',
        $html
    );

    return response($html)
        ->header('Content-Type', 'text/html')
        ->header('X-Frame-Options', 'SAMEORIGIN'); // allow the same-origin iframe
})->name('emailer.form');
```

### 3. The launcher + modal — `resources/views/components/welcome.blade.php`

Card button (daisyUI — fine, it's app chrome):
```blade
<button type="button" class="btn btn-secondary btn-sm"
        onclick="document.getElementById('bulkEmailModal').showModal()">
    Open Bulk Email
</button>
```

The modal — **self-styled with inline CSS** (see gotcha #2), using a native `<dialog>`:
```blade
<style>
    #bulkEmailModal{padding:0;border:none;background:transparent;max-width:none;max-height:none;}
    #bulkEmailModal::backdrop{background:rgba(0,0,0,.6);}
</style>
<dialog id="bulkEmailModal">
    <div style="position:relative;width:91vw;max-width:56rem;height:85vh;background:#0d1b2a;border-radius:12px;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,.55);">
        <form method="dialog" style="margin:0;">
            <button aria-label="Close" style="position:absolute;top:10px;right:10px;z-index:10;width:30px;height:30px;border-radius:9999px;border:none;background:rgba(0,0,0,.45);color:#fff;font-size:15px;cursor:pointer;">&times;</button>
        </form>
        <iframe src="{{ route('emailer.form') }}" title="Bulk Email" style="display:block;width:100%;height:100%;border:0;"></iframe>
    </div>
</dialog>
```

---

## Gotchas (learned the hard way — read these)

1. **Serve from `resources/`, never `public/`.** Files in `public/` are served by the web server directly and **bypass Laravel auth**. Serving via a route keeps it behind the `auth:sanctum` middleware.

2. **Self-style the modal with inline CSS; don't rely on daisyUI `modal`/`modal-box`.** Those daisyUI classes may **not be in the compiled CSS** unless already used elsewhere, so the box renders unstyled. Inline styles + a native `<dialog>` render correctly **with no `npm run build`** — important for FTP-only deploys. The `<iframe>` already isolates the form's own CSS, so the box just needs size + background + rounding.

3. **Inject context with `str_replace('</head>', ...)`.** Put a `<script>window.* = ...</script>` right before `</head>` so it runs before the form's own script. Encode values with `json_encode(..., JSON_UNESCAPED_SLASHES)`.

4. **`X-Frame-Options: SAMEORIGIN`.** The iframe is same-origin; set this header so framing is allowed even if global config tightens it.

5. **Route closures are not route-cached.** This app uses closure routes (dashboard, mediaengine, emailer), so `php artisan route:cache` is effectively not in play — a new closure route works on upload with no cache clear. (If you ever switch to controller routes + route caching, you must `route:clear` after adding one.)

6. **Blade views self-recompile**; uploading a newer `.blade.php` is enough, no `view:clear` needed.

7. **Cross-origin POST is fine.** The framed form can POST to an external host (e.g. `n8n.lingoit.net`) — that already works in production. Only proxy through Laravel if you need to hide a secret or add CSRF; for open/internal webhooks, direct posting is simpler and avoids holding a PHP request open for long jobs.

---

## Step-by-step: add a NEW framed tool

1. Drop the standalone file at `resources/<tool>/<tool>.html`. Have its JS read any context from `window.<THING>`.
2. Add an auth-gated route `GET /<tool>/form` that reads the file, injects context before `</head>`, returns it with `X-Frame-Options: SAMEORIGIN`.
3. Add a launcher button + a self-styled `<dialog id="<tool>Modal">` + `<iframe src="{{ route('<tool>.form') }}">` wherever it should open (dashboard card, nav, etc.).
4. Deploy: upload the 3 files (FTP is fine). No build, no cache clear. Refresh and test.

---

## Deployment notes
- **FTP-friendly:** because the modal is self-styled and routes are closures, you can deploy by uploading the changed files — **no `npm run build`, no artisan cache commands** required.
- If you ever introduce new Tailwind/daisyUI classes that aren't already compiled, you WOULD need `npm run build`. Avoid that in framed-tool work by keeping the modal's own styling inline.
