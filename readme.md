# app-wp-appointment

WordPress plugin **bookingtime appointment** — embeds bookingtime's online appointment booking into your WordPress site, with an included setup process. Published on [wordpress.org](https://wordpress.org/plugins/bookingtime-appointment/).

<img src="https://github.com/bookingtime/app-wp-appointment/blob/master/aws/logo_wordpress.png" alt="logo wordpress" width="200" />

## Requirements
- WordPress 6.0 or newer (tested up to 7.0), PHP 8.1 or newer: https://wordpress.org/about/requirements/

## How To Install
1. Download and unzip the bookingtime appointment plugin (or install it from the WordPress plugin directory).
2. Upload the plugin directory to `/wp-content/plugins/`.
3. Activate the plugin through the Plugins menu in WordPress.
4. Register and configure the settings at the appointment menu.
5. Insert the booking form into a page or post with the appointment block or the shortcode `[appointment id="YOUR_ID"]`.

Alternatively install via Composer:
```bash
composer require bookingtime/app-wp-appointment
```
see: https://packagist.org/packages/bookingtime/app-wp-appointment

## Help and docs
- Full plugin description, FAQ and changelog: [README.txt](/README.txt)
- Support for developers: https://developer.bookingtime.com
- API documentation: https://service.bookingtime.com/apidoc/module
- Technical notes for contributors: [CLAUDE.md](/CLAUDE.md), release procedure: [RELEASE.md](/RELEASE.md)

## Security
If you discover a security vulnerability within this package, please send an email to support@bookingtime.com or create a [ticket](https://developer.bookingtime.com/hc/en-us/requests/new?ticket_form_id=9359661193628). All security vulnerabilities will be promptly addressed.

Known accepted advisory: [CVE-2024-1899](https://github.com/advisories/GHSA-rmmh-p597-ppvv) (showdown, ReDoS) affects only the block build toolchain (`blocks/package-lock.json`); `@wordpress/*` packages are externalized at build time, so the vulnerable code is not part of the shipped plugin.

## Use of Third-Party Services
This plugin uses external third-party services to provide certain functionalities:

1. **bookingtime API** — retrieves and manages booking data in real time. API URL: https://api.bookingtime.com/app/v3/
2. **bookingtime OAuth Service** — authentication and authorization for the API. OAuth URL: https://auth.bookingtime.com/oauth/token

Privacy Policy: https://service.bookingtime.com/legal/de/datenschutz/bookingtime_Datenschutzbestimmungen.pdf
Terms of use: https://service.bookingtime.com/legal/de/agb/bookingtime_AGB.pdf
(If a link is missing, please check the service's website.)

## License
This plugin is distributed under the MIT License, see LICENSE file for more information.

---
Copyright 2014 bookingtime GmbH. All Rights Reserved.

Made with :blue_heart: by © bookingtime

<img src="https://github.com/bookingtime/app-wp-appointment/blob/master/aws/logo_bookingtime.png" alt="logo" width="30" height="44" />
