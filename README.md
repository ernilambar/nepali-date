# Nepali Date

Nepali Date Converter and utilities.

## Requirements

* PHP 5.6+.
* [Composer](https://getcomposer.org/) for managing PHP dependencies.

## Installation

Use Composer to install the package.

```bash
composer require ernilambar/nepali-date
```

Use this to include autoload file.

```php
require_once __DIR__ . '/vendor/autoload.php';
```

## Usage

Examples:

```php
use Nilambar\NepaliDate\NepaliDate;

$obj = new NepaliDate();

// Convert BS to AD.
$date = $obj->convertBsToAd('2077', '1', '1');

// Convert AD to BS.
$date = $obj->convertAdToBs('2020', '1', '1');

// Get Nepali date details by BS date.
$date = $obj->getDetails('2077', '1', '1', 'bs');

// Get Nepali date details by AD date.
$date = $obj->getDetails('2020', '1', '1', 'ad');
```

## Copyright and License

This project is licensed under the [MIT](http://opensource.org/licenses/MIT).

2021 &copy; [Nilambar Sharma](https://www.nilambar.net).
