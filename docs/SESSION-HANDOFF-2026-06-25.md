# Session Handoff — 2026-06-25

Working notes for picking this back up. Covers everything changed this session, what's
deployed vs. pending, and the exact steps left to finish.

> **Repo:** `Laravel Files/client-tracker/` (Laravel 12 + Livewire 3 + Jetstream/Fortify, daisyUI v5).
> **Important:** `.env` is **gitignored** — mail + n8n settings must be edited **directly on the server** (FTP/SSH), not via git push.

---

## TL;DR — what to do next (in order)

1. **Push** all code changes from GitHub Desktop, then **pull** on the live server.
2. **Edit the server `.env`** (see [Server .env](#server-env-must-be-set-manually)):
   - Gmail SMTP `MAIL_*` block (for forgot-password).
   - `N8N_BASE` + `N8N_PANEL_SECRET` (for Media Engine live data).
3. On the server: **`npm run build`** (CSS changed) then **`php artisan optimize:clear`**.
4. Reload and verify:
   - Any user can log in; forgot-password email arrives; reset link works (logged out).
   - Edit User / Edit Client modals look clean (no `$`/date misalignment, no horizontal scrollbar).
   - Dashboard → **Media Engine** card opens `/mediaengine`; "Load live roster" works once the secret is set.

---

## 1. Authentication fixes (DONE in code)

**Goal:** all existing users can log in again; forgot-password works.

- **Login crash fixed** (`Route [verification.notice] not defined`): `Features::emailVerification()`
  is intentionally off in `config/fortify.php`, but the `User` model still required email
  verification. Removed `implements MustVerifyEmail` from `app/Models/User.php` and the
  `verified` middleware from the route group in `routes/web.php`.
- A temporary "only james@lingoit.net can log in" lock was added and then **reverted** — all
  users can log in now.
- **Password-reset link 404 fixed:** `app/Providers/RouteServiceProvider.php` `HOME` was `/home`
  (no such route). Changed to `/dashboard` (matches `config/fortify.php` `home`). The reset form
  only shows when **logged out** (it's a guest route).

## 2. Mail / forgot-password (CODE done; SERVER .env pending)

- Local `.env` updated to Gmail SMTP. **The same block must be set on the server `.env`.**
- Account: `contact.lingoit@gmail.com`, `smtp.gmail.com:465` SSL, using a Google **App Password**
  (entered without spaces). If 465 errors on the server, switch to `587` + `tls`.

## 3. Public registration DISABLED (DONE in code)

- `config/fortify.php`: `Features::registration()` commented out (a random unwanted signup had
  come through). The June 3 change only hid the UI; the Fortify feature was still on. Now the
  routes are gone; `/register` redirects to login.
- **Admins still add users** via the Users screen (`UserManagement` → `User::create`), which is
  independent of Fortify registration. **Do not re-enable registration.**

## 4. Media Engine — new feature (DONE in code; SERVER config pending)

Lingo's social-media / blog content control panel, rebuilt natively to match the app.

- **Entry point:** dashboard card (`resources/views/components/welcome.blade.php`) — the old
  "Documentation" card is now **Media Engine** (Lingo orange, links to `/mediaengine`).
  *Not* in the nav menu (by request).
- **Route:** `/mediaengine` — open to any logged-in user (`routes/web.php`).
- **Built as Livewire 3:**
  - `app/Livewire/MediaEngine.php` — Set Up + Review tabs, client/channel/blog editing,
    generate drafts, approve/reject, export, **Load live roster** / **Save to sandbox**.
  - `resources/views/livewire/media-engine.blade.php` — daisyUI components on the dark theme.
  - `resources/views/mediaengine.blade.php` — `x-app-layout` page wrapper.
- **n8n calls are server-side** in the component (`Http::withHeaders(['X-Panel-Secret' => …])`),
  so the secret never reaches the browser. **No public proxy routes.**
- Source it was rebuilt from: `G:\Shared drives\ClaudeCode\Automation\Social Media Engine\index.html`.
  This **supersedes** the earlier `/social-panel` proxy build (that `SocialPanelController`
  approach was not used).
- **Needs `N8N_BASE` + `N8N_PANEL_SECRET` on the server.** Until set, it runs on seed/demo data
  and live actions fail gracefully.

## 5. Form styling fixes — daisyUI v5 (DONE in code; needs `npm run build`)

The Edit User / Edit Client modals looked jumbled because the app's forms are written in
**daisyUI v4 markup** but the project runs **daisyUI v5.0.50** (v5 removed several form classes).

- `resources/css/app.css` — added a small **v4→v5 form-layout compatibility shim**
  (restores `form-control` / `label` / `label-text` spacing; adds `min-width:0` to
  `.form-control`). Fixes spacing/alignment across **all** forms at once.
- `resources/views/livewire/client-management.blade.php` — replaced 2× removed `input-group`
  (the `$` money fields on Default Hourly Rate & Monthly Software Cost) with the v5
  `<label class="input">…<input class="grow">` idiom.
- `resources/views/livewire/user-management.blade.php` — fixed the Edit User horizontal
  scrollbar: `overflow-x-hidden` on the scroll area + `min-w-0` on the date inputs.

> ⚠️ Still needs eyeballing after deploy. The "dropdown alignment off" complaint may need a
> screenshot of the specific dropdown to confirm it's fully resolved.

---

## Server .env (must be set manually — gitignored)

```
# Mail (forgot-password)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=contact.lingoit@gmail.com
MAIL_PASSWORD=<gmail app password, no spaces>
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="contact.lingoit@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

# Media Engine -> n8n
N8N_BASE=https://n8n.lingoit.net
N8N_PANEL_SECRET=<secret>
```

- The **n8n panel secret** is intentionally kept off the shared drive. Its value is in
  `G:\Shared drives\ClaudeCode\Automation\Social Media Engine\HANDOFF.md`.
- After editing `.env`: `php artisan config:clear` (or the `optimize:clear` below).

## Deploy checklist

- [ ] Push from GitHub Desktop → pull on server.
- [ ] Server `.env`: Gmail `MAIL_*` block.
- [ ] Server `.env`: `N8N_BASE` + `N8N_PANEL_SECRET`.
- [ ] `npm run build` (CSS shim + new daisyUI classes).
- [ ] `php artisan optimize:clear`.
- [ ] (Optional, n8n side) Lock the 5 panel webhooks with Header Auth `X-Panel-Secret` — see
      `Automation/Social Media Engine/DEPLOY-control-panel-into-lingoclient.md`.

## Files changed this session

**Auth / mail:**
- `app/Models/User.php` (removed MustVerifyEmail)
- `routes/web.php` (removed `verified`; added `/mediaengine`; removed proxy routes)
- `app/Providers/RouteServiceProvider.php` (`HOME` → `/dashboard`)
- `app/Providers/FortifyServiceProvider.php` (lock added then reverted — net no change)
- `config/fortify.php` (registration disabled)
- `.env`, `.env.example` (mail + n8n keys)

**Media Engine:**
- `resources/views/components/welcome.blade.php` (dashboard card)
- `app/Livewire/MediaEngine.php` (new)
- `resources/views/livewire/media-engine.blade.php` (new)
- `resources/views/mediaengine.blade.php` (new — page wrapper)
- `config/services.php` (n8n block)
- `public/lingo-logo.png` (copied; currently unused by the component — harmless)
- *Removed:* `app/Http/Controllers/MediaEngineController.php`; CSRF exemption in
  `app/Http/Middleware/VerifyCsrfToken.php` reverted.

**Styling:**
- `resources/css/app.css` (v4→v5 form shim)
- `resources/views/livewire/client-management.blade.php` (input-group → v5)
- `resources/views/livewire/user-management.blade.php` (overflow + date min-w-0)

## Verified vs. not

- ✅ PHP lints clean; all Blade views compile (`view:cache`); Livewire namespace resolves.
- ❌ **Not browser-tested** — no local PHP server/DB here, and the local Vite build is broken
  (pre-existing env issue: Vite can't resolve its own config module). Real testing happens after
  deploy + `npm run build` on the server.

## Open items / possible next steps

- Eyeball the Edit User / Edit Client modals after `npm run build`; confirm the dropdown
  alignment issue is gone (screenshot helps if not).
- Verify Media Engine live data once the n8n secret is set on the server.
- Optional: add a "Media Engine" entry to `docs/UPDATE_SUMMARY.md` changelog (auth changes are
  already logged there; Media Engine + styling not yet).
- n8n-side webhook lock + go-live decisions are tracked in the `Automation/Social Media Engine`
  docs (`HANDOFF.md`, `PLAN-2026-06-25.md`) — separate project.

## Memory updated

Persistent notes were saved to the project memory (`project_technical_notes.md`): the auth fixes,
the `/dashboard` HOME requirement, registration-disabled, the Gmail SMTP setup, and the Media
Engine feature + its server-side n8n secret requirement.
