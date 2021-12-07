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
- This module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` to force Browser to load webp images like [css-tricks.com](https://css-tricks.com/using-webp-images/)
- There is a task `dev/tasks/WebpImageGenerationTask` to generate WebP variants for all images (jpg/png) in assets (local assets store only) if you happened to have existing images without webp variants. The task should run per CLI `php ./vendor/silverstripe/framework/cli-script.php dev/tasks/WebpImageGenerationTask` as it likely runs longer than `max_execution_time`.

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
- [ ] documentation
- [x] IMagick Support
- [x] WebpImageGenerationTask
- [ ] PHP test to check support
- [ ] Delete Webp Image 
- [ ] Flush Webp Image
