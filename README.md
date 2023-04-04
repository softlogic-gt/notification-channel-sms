# Sms notifications channel for Laravel 5.4+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/grupodkt/notification-channel-sms.svg?style=flat-square)](https://packagist.org/packages/grupodkt/notification-channel-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/grupodkt/laravel-notification-channel-sms.svg?style=flat-square)](https://packagist.org/packages/grupodkt/notification-channel-sms)

This package makes it easy to send [Sms notifications] with Laravel 5.4.

## Contents
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require grupodkt/notification-channel-sms
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Sms\SmsProvider::class,
],
```

### Setting up your Waba account

Add your Sms Url, Auth Token, and phoneNumberId to your `config/services.php`:

```php
// config/services.php
...
'sms' => [
    'url'   => env('SMS_URL'),
    'token' => env('SMS_TOKEN'),
    'phoneNumberId' => env('SMS_PHONE_NUMBER_ID'),
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Sms\SmsChannel;
use NotificationChannels\Sms\SmsMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return (new SmsMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```

In order to let your Notification know which phone are you sending/calling to, the channel will look for the `celular` attribute of the Notifiable model. If you want to override this behaviour, add the `routeNotificationForSms` method to your Notifiable model.

```php
public function routeNotificationForSms()
{
    return $this->mobile;
}
```

### Available Message methods

#### SmsMessage

- `from('')`: Accepts a phone to use as the notification sender.
- `content('')`: Accepts a string value for the notification body.
- `idCode(0)`: Accepts a integer value for the correlative id message.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email carodas@grupodkt.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [GRUPODKT](https://github.com/grupodkt)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
