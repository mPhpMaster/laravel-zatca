# Laravel-ZATCA 
*Unofficial package to implement ZATCA QRcode for E-Invoicing.*

## Requirements

* PHP >= 7.4
* An mbstring extension

## Dependencies
* [chillerlan/php-qrcode](https://github.com/chillerlan/php-qrcode)

## Installation
Via composer:

```bash
$ composer require mphpmaster/laravel-zatca
```

## Usage

### Generate Base64

```php
$value = \MPhpMaster\ZATCA\TagBag::make()
    ->addCompany('Company name')
    ->addVatId('1234567891')
    ->addInvoiceDate('2021-11-24T03:48:00Z')
    ->addInvoiceTotalAmount('100')
    ->addVatAmount('15')
    ->toBase64();

// > Output
// AQxDb21wYW55IG5hbWUCCjEyMzQ1Njc4OTEDFDIwMjEtMTEtMjRUMDM6NDg6MDBaBAMxMDAFAjE1
```

### Generate Plain

```php
$value = \MPhpMaster\ZATCA\TagBag::make()
    ->addCompany('Company name')
    ->addVatId('1234567891')
    ->addInvoiceDate('2021-11-24T03:48:00Z')
    ->addInvoiceTotalAmount('100')
    ->addVatAmount('15')
    ->toTLV();
```

### Get The QRCode Image

```php
$value = \MPhpMaster\ZATCA\TagBag::make()
    ->addCompany('Company name')
    ->addVatId('1234567891')
    ->addInvoiceDate('2021-11-24T03:48:00Z')
    ->addInvoiceTotalAmount('100')
    ->addVatAmount('15')
    ->toImage();

// <img src="$value" alt="ZATCA QRCode" />
```

## Testing

```bash
vendor/bin/phpunit
```

## Copyright and license

Copyright © 2021 hlaCk (https://github.com/mPhpMaster)

Licensed under the **MIT License** (https://github.com/mPhpMaster/laravel-zatca/blob/master/LICENSE) license.

***


