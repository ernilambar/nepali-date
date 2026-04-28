# Nepali Date

[![Stable Version](https://img.shields.io/packagist/v/ernilambar/nepali-date?label=Stable&color=329FD4)](https://packagist.org/packages/ernilambar/nepali-date)
[![Type: Library](https://img.shields.io/badge/Type-Library-brightgreen.svg)](https://packagist.org/packages/ernilambar/nepali-date)
[![PHP Version](https://img.shields.io/packagist/dependency-v/ernilambar/nepali-date/php)](https://packagist.org/packages/ernilambar/nepali-date)
[![License](https://img.shields.io/packagist/l/ernilambar/nepali-date?label=License)](https://github.com/ernilambar/nepali-date/blob/master/LICENSE)

**Nepali (Bikram Sambat) calendar utilities and BS ↔ AD (Gregorian) date conversion for PHP.** This package converts between BS and AD dates and exposes helpers for formatted labels (English or Nepali script).

## Requirements

* PHP 5.6+.
* [Composer](https://getcomposer.org/) for managing PHP dependencies.

## Installation

Install the package with Composer (see [Packagist](https://packagist.org/packages/ernilambar/nepali-date)):

```bash
composer require ernilambar/nepali-date
```

### Autoloading

Require Composer’s autoload once from your project root (where `vendor/` lives).

```php
require_once __DIR__ . '/vendor/autoload.php';
```

## Usage

Examples use **integers** for year, month, and day. The API also accepts **numeric strings** (e.g. `'2077'`) where values are used numerically.

```php
use Nilambar\NepaliDate\NepaliDate;

$obj = new NepaliDate();

// Convert BS to AD.
$date = $obj->convertBsToAd(2077, 1, 1);

// Convert AD to BS.
$date = $obj->convertAdToBs(2020, 1, 1);

// Date details for a BS date (language: 'en' or 'np' for Devanagari numerals / labels).
$date = $obj->getDetails(2077, 1, 1, 'bs', 'en');
$date = $obj->getDetails(2077, 1, 1, 'bs', 'np');

// Date details for an AD date (converted internally, then formatted like BS).
$date = $obj->getDetails(2020, 1, 1, 'ad', 'en');
```

`getDetails( $year, $month, $day, $type, $language )`: `$type` is `'bs'` or `'ad'`; `$language` is optional and defaults to `'en'`.

## Supported ranges

Conversions rely on a **fixed embedded calendar table**. In practice:

* **Gregorian (AD):** years **1944–2033** are considered by the range checks; only dates that exist in the table can be converted (the first supported pair is **1944-01-01** ↔ **BS 2000-09-17**, and the last supported AD day in the current data is **2033-04-13** ↔ **BS 2089-12-30**).
* **Bikram Sambat (BS):** years **2000–2089** are in range; individual month/day combinations must still exist in the table (invalid or out-of-range inputs typically yield an **empty array** from conversion methods).

## Copyright and License

This project is licensed under the [MIT](http://opensource.org/licenses/MIT).

2026 &copy; [Nilambar Sharma](https://www.nilambar.net).
