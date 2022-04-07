# silverstripe-webp-image
[![License](https://poser.pugx.org/nomidi/silverstripe-webp-image/license)](https://packagist.org/packages/nomidi/silverstripe-webp-image)


## Introduction
This module creates webp image variants for jpeg and png images. More Information about webp images [https://developers.google.com/speed/webp/](https://developers.google.com/speed/webp/). For now this module explicitly prohibits uploading webp images, since those 'll be generated.

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
- This module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` to force Browser to load webp images like [css-tricks.com](https://css-tricks.com/using-webp-images/)
- There is a task `dev/tasks/WebpImageGenerationTask` to generate WebP variants for all images (jpg/png) in assets (local assets store only). It 'll generate webp variants for all existing images. The task should run per CLI `php ./vendor/silverstripe/framework/cli-script.php dev/tasks/WebpImageGenerationTask` as it likely runs longer than `max_execution_time`.
- Also there is `dev/tasks/WebpImagePurgeTask`. It'll remove all webP variants if an original file (jpg/png) exists.


## Caveats
This module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` template. If you're running other modules doing so like [`lerni/folderindex`](https://github.com/lerni/folderindex), you'll have to maintain your own version of it.


## Test if webp is available
Run `phpinfo()` or chekc with the snippet below to check if if webp is available with the installed GD Library. Simply copy this code into a `.php` file in your `root` folder and open the file in a browser.
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
- [x] WebpImagePurgeTask
- [ ] delete WebP variants on delete
- [ ] fix issue if webP variants are generated in `.protected` and not aren't directly published. `dev/tasks/WebpImageGenerationTask` as cron task circumvents this, but 'll leave artefacts in `.protected` folders.
