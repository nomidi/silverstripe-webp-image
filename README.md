# silverstripe-webp-image

[![Build Status](https://travis-ci.org/nomidi/silverstripe-webp-image.svg?branch=master)](https://travis-ci.org/nomidi/silverstripe-webp-image)
[![License](https://poser.pugx.org/nomidi/silverstripe-webp-image/license)](https://packagist.org/packages/nomidi/silverstripe-webp-image)


## Introduction

This module creates webp images from resized jpeg and png images. More Information about webp images [https://developers.google.com/speed/webp/](https://developers.google.com/speed/webp/)

## Requirements

- Silverstripe > 4.2
- GDLib or imagick with webp Extension

## Installation

```sh
composer require nomidi/silverstripe-webp-image
```

## Usage

- run `dev/build?flush=1`


- force Browser to load webp image // Example 1 (default)
edit `.htaccess` in your `root` directory, and add `webp` forwarding in compatible browsers


- force Browser to load webp image // Example 2
for information on usage of webp image in html see [css-tricks.com](https://css-tricks.com/using-webp-images/)

## Quick Testfile for checking if webp is available

Below you will find the code to quickly check if webp is available with the installed GD Library. Simply copy this code into a `.php` file in your `root` folder and open the file in a browser.

```php
<?php

if (function_exists('imagewebp')) {
    echo "WebP is available";
} else {
    echo "WebP is not available";
}

```

## TODO
- documentation
- IMagick Support
- PHP test to check support
- Delete Webp Image 
- Flush Webp Image