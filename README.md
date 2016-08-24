# PanaceaMobile notifications channel for Laravel 5.3 [WIP]

[![Latest Version on Packagist](https://img.shields.io/packagist/v/Sbudah/panaceamobile.svg?style=flat-square)](https://packagist.org/packages/Sbudah/panaceamobile)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/Sbudah/panaceamobile/master.svg?style=flat-square)](https://travis-ci.org/Sbudah/panaceamobile)
[![StyleCI](https://styleci.io/repos/65589451/shield)](https://styleci.io/repos/65589451)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/aceefe27-ba5a-49d7-9064-bc3abea0abeb.svg?style=flat-square)](https://insight.sensiolabs.com/projects/aceefe27-ba5a-49d7-9064-bc3abea0abeb)
[![Quality Score](https://img.shields.io/scrutinizer/g/Sbudah/panaceamobile.svg?style=flat-square)](https://scrutinizer-ci.com/g/Sbudah/panaceamobile)
[![Total Downloads](https://img.shields.io/packagist/dt/Sbudah/panaceamobile.svg?style=flat-square)](https://packagist.org/packages/Sbudah/panaceamobile)

This package makes it easy to send notifications using [PanaceaMobile](panaceamobile.com) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the PanaceaMobile service](#setting-up-the-PanaceaMobile-service)
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

```bash
composer require laravel-notification-channels/smsc-ru
```

You must install the service provider:
```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\PanaceaMobile\PanaceaMobileServiceProvider::class,
];
```

### Setting up the PanaceaMobile service

Add your PanaceaMobile login, secret key (hashed password) and default sender name  to your `config/services.php`:

```php
// config/services.php

'panaceamobile' => [
    'login'  => env('PANACEAMOBILE_LOGIN'),
    'secret' => env('PANACEAMOBILE_SECRET'),
    'sender' => 'Sbudah'
]
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\PanaceaMobile\PanaceaMobileMessage;
use NotificationChannels\PanaceaMobile\PanaceaMobileChannel;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [PanaceaMobileChannel::class];
    }

    public function toPanaceaMobile($notifiable)
    {
        return (new PanaceaMobileMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```

### Available methods

TODO

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [JhaoDa](https://github.com/jhaoda)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
