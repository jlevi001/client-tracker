# Deployment

## How the live site updates

**lingoclient.com** runs on **Cloudways**, which is wired to **auto-pull from this GitHub repo** (`jlevi001/client-tracker`, `main` branch). A `git push` to `main` deploys to production **automatically, within minutes** — there is no separate deploy step.

- Server document root: `/applications/fmayejttab/public_html/`
- FTP access to that path exists for manual hotfixes / verification only. The normal path to production is a GitHub push.

## The rule: never push a partial multi-file feature

Because every push goes live fast, an incomplete change reaches production before you've finished it. If a file that's live references something that isn't live yet, the whole page 500s.

**Commit and push all files a feature depends on together, in one push.**

### Worked example (2026-06-30 dashboard outage)

The dashboard (`resources/views/components/welcome.blade.php`) was deployed with a Bulk Email modal:

```blade
<iframe src="{{ route('emailer.form') }}" ...>
```

but the route that defines `emailer.form` (`routes/web.php`) and the file it serves
(`resources/emailer/emailer.html`) had not reached the server yet. Result:

```
Symfony\Component\Routing\Exception\RouteNotFoundException
Route [emailer.form] not defined.
```

The dashboard 500'd until `routes/web.php` landed on the server. The emailer feature
spans three files that must ship together:

- `routes/web.php` — defines `emailer.form`
- `resources/emailer/emailer.html` — served by that route via `file_get_contents(resource_path('emailer/emailer.html'))`
- `resources/views/components/welcome.blade.php` — the modal/iframe that calls `route('emailer.form')`

## Caches

There is no compiled route cache (`bootstrap/cache/` has no `routes-*.php`), so an updated
`routes/web.php` takes effect as soon as it's on the server — nothing to clear.
