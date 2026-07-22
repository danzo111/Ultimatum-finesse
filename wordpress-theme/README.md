# Ultimatum Finesse — WordPress theme

Converts the static site into a custom WordPress theme (Option B from the quote).

**Status: fully built and verified working** on a local test install (Local by WP Engine). Every page, both maps' interactivity, the contact form, the mobile nav, and console output were checked end-to-end — see "What's been verified" below. Production (`ultimatumfinesse.co.bw`) has not been touched yet; it's still running the original Sinatra/WPBakery theme.

## What's here

```
ultimatum-finesse/
  style.css              Required WP theme header (metadata only)
  functions.php          Enqueues, nav menu registration, conditional Leaflet loading
  header.php             <head>, skip link, site header, nav, opens <main>
  footer.php             Closes </main>, site footer, wp_footer()
  front-page.php         Homepage (hero, stats, services grid, about teaser, logo marquee, CTA)
  page.php               Generic template — About and Insights use this
  page-services.php      Template Name: Services
  page-projects.php      Template Name: Projects
  page-contact.php       Template Name: Contact
  css/style-main.css     The actual site stylesheet (unchanged content, copied as-is)
  js/main.js             Unchanged — nav, scroll reveals, counters, contact form
  js/map.js              Rewritten: fetches project data instead of holding it inline
  assets/                All images + the Company Profile PDF, copied as-is
  assets/data/projects.json   The 16 project pins, extracted out of map.js
```

## Deviations from the plan, and why

- **`<main>` split across header.php/footer.php, not each template.** The plan described header.php as ending after the nav. I put the opening `<main id="main">` at the end of header.php and the closing `</main>` at the start of footer.php instead, so none of the 5 page templates have to remember to wrap their own content in `<main>`. This is the standard WordPress theme pattern (used by `_s`/Underscores and most themes) and removes a whole class of "forgot to close main" bugs.

- **Leaflet loads on 3 templates, not just Projects.** The plan's functions.php step said to enqueue Leaflet "only when `is_page_template('page-projects.php')`". That's incomplete — the homepage has the hero mini-map, and Contact has the office-location map, both built with the same `L.map(...)` calls. `uf_page_uses_leaflet()` in functions.php checks `is_front_page() || is_page_template('page-projects.php') || is_page_template('page-contact.php')`. Without this, the homepage and Contact maps would silently fail (Leaflet undefined).

- **`wp_nav_menu()` doesn't produce the CSS the original active-link styling expects.** The static site hardcoded `class="active"` directly on the current page's `<a>`. WordPress's menu walker instead puts `current-menu-item` / `current_page_item` on the parent `<li>`. I added a CSS rule in `style-main.css` (`.main-nav .current-menu-item > a`) so the green active-link color still works — without it, the nav would render fine but never highlight the current page.

- **`page.php` (About, Insights) is genuinely just title + `the_content()`.** This matches what the plan asked for, but worth being clear about the tradeoff: the *current* About page has a photo grid, a timeline, and a values grid; Insights has curated article cards with real external links and photo credits. None of that structured layout survives through a plain WordPress editor unless whoever edits those pages pastes matching HTML (e.g. via the Custom HTML block) into the content area. If you want About/Insights to keep their current look without depending on someone hand-authoring HTML in wp-admin, they'd need their own `page-about.php` / `page-insights.php` templates, the same way Services/Projects/Contact got one. I didn't build those since the plan explicitly called for the generic route — say the word if you want them built the same way as the other three.

- **Project data moved to JSON, `map.js` is now async.** Per step 8. `initUfMap()` is now `async` and fetches `assets/data/projects.json` (URL supplied by PHP via `wp_localize_script`, not hardcoded in JS). The map itself renders immediately; markers populate a beat later once the fetch resolves — not noticeable in practice, but worth knowing it's no longer perfectly synchronous.

## A real bug the install caught: `index.php` was missing

The first upload attempt failed with *"Template is missing. Standalone themes need to have a templates/index.html or index.php template file."* WordPress requires `index.php` at the theme root as the fallback template (used for anything `front-page.php`/`page.php`/the `page-*.php` templates don't cover, and its presence is literally what the installer checks to confirm it's a real theme). Added — it's a minimal title + `the_content()` fallback, same shape as `page.php`.

## What's been verified (on the local test install)

- Theme installs and activates without errors (post-`index.php`-fix)
- Homepage: hero, stats, services grid, logo marquee, hero mini-map with real pins (confirms the async JSON fetch + `wp_localize_script` pipeline works)
- All 6 nav pages load with the correct template and correct active-state highlighting (the `current-menu-item` CSS fix works)
- Services: full 7-service detail layout renders
- Projects: satellite map + category filters actually tested (clicking "LiDAR & Dam Surveys" correctly hides non-matching pins)
- Contact: office map renders real Gaborone satellite imagery with street labels; full contact-form submit tested (success message shows, fields reset)
- Mobile (real 390×844 viewport, not just DevTools): hero stacks correctly, hamburger menu opens with all 6 links and correct active highlighting, Projects' filter buttons wrap cleanly
- Zero console errors on any page

Not yet verified on this local install: About/Insights only have placeholder paragraph text (`"Placeholder text — replace with..."`), not real copy — that's expected, not a bug, per the content pass below. (This has since been done for real on the Bluehost staging clone — see "Content pass" further down.)

## Second verification pass: Bluehost's native staging clone

Beyond the local install, the theme was also deployed to a **real clone of production** — Bluehost includes free one-click staging (Appearance → Settings → Staging in `wp-admin`, no extra plugin/account needed), which clones the live site's actual files and database to `ultimatumfinesse.co.bw/staging/<id>/`. This is a stronger test than the local install because it runs against the site's real content, real plugins (WPBakery, Yoast, Redux, WP Super Cache, etc.), and real page IDs — exactly the environment production deploy will hit.

**Key difference from the local install: existing pages were reused, not recreated.** The live site already had pages for About Us, Contact Us, Our Services, and Our Projects (all from 2020, running through WPBakery Page Builder). Rather than creating fresh `about`/`services`/etc. pages, the *existing* pages got a template assigned via Page Attributes — this keeps their original URLs and SEO history intact. Only `Insights` needed to be created from scratch, since the old site had no equivalent (just a `Blog` posts-page, which was swapped out of the nav for the new Insights page). About Us kept its original 2020 WPBakery copy at first, but that content didn't match the redesign — see the content pass below, which replaced it.

**A real, reproducible bug found here that the local install never hit:** assigning a Page Template via the **Classic Editor's** Page Attributes panel and clicking **Update** does not reliably persist on this site — the dropdown shows the new value, but the saved page keeps rendering `page-template-default` (confirmed via `document.body.className`, which is the authoritative signal, not the dropdown's visual state). This is almost certainly WPBakery Page Builder or Redux Framework's own `save_post` hook overwriting `_wp_page_template` during its save routine. **The fix:** open the same page in the **block editor** instead (there's a "Gutenberg Editor" toggle at the top of the classic edit screen, or append `&vcv-gutenberg-editor` to the edit URL), set the Template there, and click **Save**. That save path isn't intercepted and persists correctly every time. If a template assignment ever looks like it didn't take (old content still showing, wrong H1), this is the first thing to check — don't assume the template is broken.

**Also relevant on this specific host:** **WP Super Cache** is active. After any content/template change, click **Delete Cache** in the wp-admin toolbar and hard-reload before judging whether a fix worked — otherwise you're looking at a stale cached page and will misdiagnose a caching issue as a code issue (this cost real time during the staging pass).

## Content pass: About Us and Insights, done on staging

The generic `page.php` route (see the deviation noted above) means About Us and Insights only render real content if someone pastes matching HTML into a Custom HTML block. That's now done, directly on the Bluehost staging clone, so it doubles as a template for the eventual production pass:

- **About Us** (post 909): Custom HTML block holds the Our Story/Vision/Mission copy, the 3-photo `.about-photo-grid`, the 4-item `.timeline`, the "How we work" `.process-strip`, and the "What Drives Us" `.services-grid` values cards — all matching `about.html`. The "Ultimatum Finesse Short Story" YouTube video (id `Lm2VE8BjzXM`, recovered from the old page's `[vc_video]` shortcode before it was deleted) is re-embedded at the bottom as a standard responsive iframe.
- **Insights** (post 2684): Custom HTML block holds the featured LiDAR article and the 6-card `.articles-grid` (GIS/Esri, Orthomosaic/Heliguy, Point Clouds/FARO, BIM/Autodesk, RTK GPS/Emlid, Stockpile/DroneDeploy), matching `insights.html` exactly — same external links, same Wikimedia photo credits.
- Both pages use the theme's real asset URLs (`.../wp-content/themes/ultimatum-finesse/assets/...`), not the static site's relative paths, since the HTML is pasted as raw content rather than templated.

**A real editor quirk hit while doing this, worth knowing about:** typing a large HTML block into WPBakery's Custom HTML modal via simulated keystrokes is unreliable — past a few thousand characters, the modal's live-preview pane re-renders on every keystroke and the input can lag or drop characters, corrupting the paste partway through. **Fix: build the HTML in a file, load it onto the OS clipboard, and paste (Ctrl+V) into the textarea instead of typing it.** One paste event, no per-keystroke re-render. Verify the result by reading the textarea's actual `.value` in the browser console (length + start/end checks) rather than trusting a screenshot — screenshots of this modal can show transient/stale paint, especially right after a paste or a fast programmatic scroll.

## Steps for the real production deploy (`ultimatumfinesse.co.bw`, no `/staging/` path)

This is now a known-good, twice-verified process — local install first, Bluehost staging clone second. Production is the same steps a third time, for real:

1. **Upload the theme zip and activate it.** Appearance → Themes → Add New → Upload Theme → `ultimatum-finesse.zip` → Install → **Activate**. Manual step (file-picker dialogs can't be automated) and it takes effect immediately for real visitors.
2. **Assign templates to the existing pages** — About Us, Contact Us, Our Services, Our Projects already exist on production with real content/history; do not recreate them. Open each in the **block editor** (not Classic/WPBakery mode — see the bug above), set Page Attributes → Template to Contact/Services/Projects respectively (About Us needs no template — generic `page.php` is correct), and **Save**.
3. **Create the Insights page** (title "Insights", default template) and **remove/replace "Our Blog"** in the Primary menu with it, positioned between Projects and Contact.
4. **Settings → Reading** — confirm the static homepage is already set to `Home` (it should already be, from the original site setup).
5. **Delete Cache** in the wp-admin toolbar (WP Super Cache is active) after every change, before judging the result.
6. **Content pass** — paste the same Custom HTML content used on staging into About Us and Insights (see "Content pass" above for exactly what each page needs and the clipboard-paste method for getting it into WPBakery's modal without corruption).
7. **QA pass on production** — repeat the checks from "What's been verified" above, on the real domain this time. Pay particular attention to confirming `document.body.className` shows the right `page-template-*` class on Services/Projects/Contact, not just that the dropdown looked right in the editor.
