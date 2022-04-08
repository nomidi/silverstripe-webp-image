# silverstripe-webp-image
[![License](https://poser.pugx.org/nomidi/silverstripe-webp-image/license)](https://packagist.org/packages/nomidi/silverstripe-webp-image)


## Introduction
This module creates webp image variants for jpeg and png images. More Information about webp images [https://developers.google.com/speed/webp/](https://developers.google.com/speed/webp/).

## Requirements
- Silverstripe > 4.2
- PHP 7.1 (IMAGETYPE_WEBP)
- GDLib or imagick with webp Extension


## Installation

```sh
composer require nomidi/silverstripe-webp-image
```


## Usage
- run `dev/build?flush=1`
- This module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` to force Browser to load webp images like [css-tricks.com](https://css-tricks.com/using-webp-images/). If you're running other modules doing so like [`lerni/folderindex`](https://github.com/lerni/folderindex), you'll have to maintain your own version of it.
- There is a task `dev/tasks/WebpImageGenerationTask` to generate WebP variants for all images (jpg/png) in assets (local assets store only). It 'll generate webp variants for all existing images. The task should run per CLI `php ./vendor/silverstripe/framework/cli-script.php dev/tasks/WebpImageGenerationTask` as it likely runs longer than `max_execution_time`.
- Also there is `dev/tasks/WebpImagePurgeTask`. It'll remove all webP variants, if an original file (jpg/png) exists.


## Test if webp is available
Run `phpinfo()` and check if GD or imagick support `webp`. You also can check with the snippet below, to see if if webp is available with the installed GD Library. Copy this code into a `.php` file in your `root` folder and open the file in a browser.
```php
<?php

if (function_exists('imagewebp')) {
    echo "WebP is available";
} else {
    echo "WebP is not available";
}
```


## TODO
- [x] IMagick Support
- [x] WebpImageGenerationTask
- [x] WebpImagePurgeTask
- [ ] delete WebP variants on delete
- [ ] fix issue if webP variants are generated in `.protected` and aren't directly published. Running `dev/tasks/WebpImageGenerationTask` as cron task kinda circumvents this, but 'll leave artefacts in `.protected` folders - `dev/tasks/WebpImagePurgeTask` cleans those up.
