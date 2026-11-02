# CLAUDE.md

@../bokonetlocaldev/docs/projekte/app-wp-appointment.md

Project context (maintainers, release accounts, status, open points) lives in the centrally imported project
profile; this file contains only the technical part of the plugin. **This repository is public** — keep
customer data, internal hostnames, ticket contents and personal names out of code, docs and commits.

## What this is

WordPress plugin **bookingtime appointment** (plugin folder `bt_appointment`, wordpress.org slug
`bookingtime-appointment`). It embeds bookingtime's online booking module into a WordPress site: an admin
wizard (steps 1–3) registers the site owner with bookingtime or connects an existing booking page via the
bookingtime API (`bookingtime/lib-phpsdk-app`), stores booking URLs, and the frontend renders the booking
iframe via the `[appointment id="…"]` shortcode or the Gutenberg block.

Sibling plugins with the same concept: `app-t3-appointment` (TYPO3) and `app-joomla-appointment` (Joomla).

## Layout

- `bt_appointment.php` — bootstrap: plugin header, `APPOINTMENT_VERSION`, `APPOINTMENT_PLUGIN_URL`
  (always use this for asset URLs — the folder is `bookingtime-appointment/` when installed from
  wordpress.org), block registration, activation/deactivation hooks.
- `includes/` — `class-appointment.php` (core/loader wiring), `class-appointment-activator.php`
  (creates table `{$wpdb->prefix}appointment`: id, title, url), `class-appointment-i18n.php`.
- `admin/` — `class-appointment-admin.php` (wizard, listing), Twig templates in `admin/templates/`.
- `public/` — `class-appointment-public.php` (shortcode/frontend), Twig templates in `public/templates/`.
- `blocks/` — Gutenberg block (`block.json`, `src/`, built bundle in `build/`).
- `assets/` — runtime CSS/JS (Bootstrap, Lightbox), `icon.png` for the admin menu; the banner/screenshot
  images here mirror the wordpress.org listing assets.
- `vendor/` — **committed** Composer dependencies (Twig 3, Symfony 5.4 translation/config/twig-bridge, SDK).
  Change only via `composer update`, then commit the whole directory.
- `README.txt` — wordpress.org readme (`Stable tag`, `Tested up to`, changelog); `RELEASE.md` — SVN
  release procedure (German).

## Commands

```bash
composer update <package>          # PHP deps; commit vendor/ + composer.lock
cd blocks && npm ci                # block toolchain (@wordpress/scripts)
npm start                          # dev watch
npx wp-scripts build               # rebuild blocks/build (committed, shipped)
npm audit                          # toolchain advisories; see overrides in blocks/package.json
```

There is no PHP test suite or linter. Verify in a local multi-version WordPress setup (6.x and 7.x):
activate the plugin, run the wizard, insert shortcode and block, check the frontend iframe. Test with the
plugin folder named `bookingtime-appointment/` to catch hard-coded paths.

## Conventions

- Version appears in **three** places and must match: plugin header `Version:`, `APPOINTMENT_VERSION`,
  `README.txt` `Stable tag:`.
- Requires PHP 8.1 (Twig 3.28 platform check) and WordPress ≥ 6.0; raise `Tested up to` with every
  release.
- `@wordpress/*` packages are externalized against core scripts at build time — toolchain-only
  advisories (e.g. showdown CVE-2024-1899, puppeteer-core/extract-zip) do not ship in `blocks/build/`.
  Document accepted advisories in the commit message and, if user-visible, in the readme.
- Releases go to wordpress.org via SVN (`RELEASE.md`); the SVN commit is live immediately, so test the
  trunk ZIP before committing. Git tags `v<version>` mirror the releases; Packagist tracks the tags.
- Commit messages: `typ: beschreibung` (`fix`, `feat`, `docs`, `release`, `chore`, `fix(security)`).
