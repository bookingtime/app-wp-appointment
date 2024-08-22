# app-wp-appointment
Wordpress extension appointment, booking module wrapper for CMS Wordpress with included setup process.

<img src="https://github.com/bookingtime/app-wp-appointment/blob/master/aws/logo_wordpress.png" alt="logo wordpress" width="200" />



## Requirements
- Wordpress version 6: https://wordpress.org/about/requirements/



## How To Install
1. Download and unzip the bookingtime oninetermine plugin
2. Upload the entire appointment/ directory to the /wp-content/plugins/ directory
3. Activate the appointment plugin through the Plugins menu in WordPress
4. Register and configure the settings at the appointment menu.
5. To insert the appointment form into some content or post use the icon appointment that will appear when editing contents or the shortcode [appointment id="YOUR_ID"] method.

Another way to install the extension is through Composer.
```bash
composer require bookingtime/app-wp-appointment
```
see: https://packagist.org/packages/bookingtime/app-wp-appointment



## Help and docs
- More [informarion](/README.txt) about this extension in the README.txt file
- Support for developers: https://developer.bookingtime.com
- See the full API documentation under https://service.bookingtime.com/apidoc/module



## Security
If you discover a security vulnerability within this package, please send an email to support@bookingtime.com or create a [ticket](https://developer.bookingtime.com/hc/en-us/requests/new?ticket_form_id=9359661193628). All security vulnerabilities will be promptly addressed.



## License
This extension is distributed under the MIT License, see LICENSE file for more information.


## Use of Third-Party Services
This plugin uses external third-party services to provide certain functionalities. Below is a description of the services used in this plugin, along with links to their terms of service and privacy policies.

### Third-Party Services Used

1. BookingTime API

    Description: This plugin accesses the BookingTime API to retrieve and manage booking data.
    Circumstances of Use: The API is used to synchronize data in real-time and process booking requests.
    API URL: https://api.bookingtime.com/app/v3/
    Privacy Policy: https://service.bookingtime.com/legal/de/datenschutz/bookingtime_Datenschutzbestimmungen.pdf (If the link is missing, please check the service's website)
    Terms of use: https://service.bookingtime.com/legal/de/agb/bookingtime_AGB.pdf (If the link is missing, please check the service's website)

2. BookingTime OAuth Service

    Description: This plugin uses the BookingTime OAuth Service to manage authentication and authorization processes.
    Circumstances of Use: The OAuth service is used to securely access the BookingTime API.
    OAuth URL: https://auth.bookingtime.com/oauth/token
    Privacy Policy: https://service.bookingtime.com/legal/de/datenschutz/bookingtime_Datenschutzbestimmungen.pdf (If the link is missing, please check the service's website)
    Terms of use: https://service.bookingtime.com/legal/de/agb/bookingtime_AGB.pdf (If the link is missing, please check the service's website)


---
Copyright 2014 bookingtime GmbH. All Rights Reserved.

Made with :blue_heart: by © bookingtime

<img src="https://github.com/bookingtime/module-wp-appointment/blob/master/aws/logo_bookingtime.png" alt="logo" width="30" height="44" />
