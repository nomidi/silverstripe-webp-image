# silverstripe-webp-image

[![Build Status](https://travis-ci.org/nomidi/silverstripe-webp-image.svg?branch=master)](https://travis-ci.org/nomidi/silverstripe-webp-image)
[![License](https://poser.pugx.org/nomidi/silverstripe-webp-image/license)](https://packagist.org/packages/nomidi/silverstripe-webp-image)


## Introduction

This module creates webp images from resized jpeg and png images. More Information about webp images [https://developers.google.com/speed/webp/](https://developers.google.com/speed/webp/)

## Requirements

- Silverstripe 3.6
- GDLib with webp Extension

## Installation

```sh
composer require nomidi/silverstripe-webp-image
```

## Usage

- run `dev/build?flush=1`
- edit `.htaccess` in your `assets` folder, and add `webp` as allowed extension.

```sh
<FilesMatch "\.(?i:html|htm|xhtml|js|css|bmp|png|gif|jpg|jpeg|ico|pcx|tif|tiff|au|mid|midi|mpa|mp3|ogg|m4a|ra|wma|wav|cda|avi|mpg|mpeg|asf|wmv|m4v|mov|mkv|mp4|ogv|webm|swf|flv|ram|rm|doc|docx|dotx|dotm|txt|rtf|xls|xlsx|xltx|xltm|pages|ppt|pptx|potx|potm|pps|csv|cab|arj|tar|zip|zipx|sit|sitx|gz|tgz|bz2|ace|arc|pkg|dmg|hqx|jar|xml|pdf|gpx|kml|webp)$">
	Allow from all
</FilesMatch>
```
- force Browser to load webp image // Example 1
edit `.htaccess` in your `root` directory, and add `webp` forwarding in compatible browsers

```sh
### Serve WebP if available and supported
<IfModule mod_rewrite.c>
  RewriteEngine On
  # Check if browser support WebP images
  RewriteCond %{HTTP_ACCEPT} image/webp
  # Check if WebP replacement image exists
  RewriteCond %{DOCUMENT_ROOT}/$1_$2.webp -f
  # Serve WebP image instead
  RewriteRule (assets.+)\.(jpe?g|png)$ $1_$2.webp [T=image/webp,E=accept:1]
</IfModule>

<IfModule mod_headers.c>
  Header append Vary Accept env=REDIRECT_accept
</IfModule>

<IfModule mod_mime.c>
  AddType image/webp .webp
</IfModule>
```
- force Browser to load webp image // Example 2
for information on usage of webp image in html see [css-tricks.com](https://css-tricks.com/using-webp-images/)

## Quick Testfile for checking if webp is available

Below you will find the code to quickly check if webp is available with the installed GD Library. Simply copy this code into a `.php` file in your `root` folder and open the file in a browser.

```php
<?php

if (function_exists(imagewebp)) {
    echo "WebP is available";
} else {
    echo "WebP is not available";
}

```

## TODO
- documentation
- IMagick Support
- PHP test to check support
