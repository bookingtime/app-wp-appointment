# lib-phpsdk-app
php SDK for bookingtime app-API

<img src="https://github.com/bookingtime/lib-phpsdk-app/blob/master/aws/logo_php.png" alt="logo php" width="150" height="100" />



## Requirements
- PHP >= 7.3
- A PSR-4 implementation



## How To Install
The recommended way to install the SDK is through Composer.
```bash
composer require bookingtime/lib-phpsdk-app
```
see: https://packagist.org/packages/bookingtime/lib-phpsdk-app



## Getting Started
```php
<?php
use bookingtime\phpsdkapp\Sdk;

//create SDK
$sdk=new Sdk(
   '<CLIENT_ID>',
   '<CLIENT_SECRET>',
   ['locale'=>'en','timeout'=>15,'mock'=>FALSE]
);

//load appointment from API
$appointment=$sdk->appointment_show([
   'organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
   'appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
]);
```


## Help and docs
- Support for developers: https://developer.bookingtime.com
- See the full API documentation under https://service.bookingtime.com/apidoc/app



## Security
If you discover a security vulnerability within this package, please send an email to support@bookingtime.com or create a [ticket](https://developer.bookingtime.com/hc/en-us/requests/new?ticket_form_id=9359661193628). All security vulnerabilities will be promptly addressed.



## License
This SDK is distributed under the MIT License, see LICENSE file for more information.



---
Copyright 2014 bookingtime GmbH. All Rights Reserved.

Made with :blue_heart: by © bookingtime

<img src="https://github.com/bookingtime/lib-phpsdk-app/blob/master/aws/logo_bookingtime.png" alt="logo" width="30" height="44" />
