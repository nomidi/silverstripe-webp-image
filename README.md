# silverstripe-webp-image
[![License](https://poser.pugx.org/nomidi/silverstripe-webp-image/license)](https://packagist.org/packages/nomidi/silverstripe-webp-image)


## Introduction
This module creates webp variants for jpeg and png images. More Information about webp images: [https://developers.google.com/speed/webp/](https://developers.google.com/speed/webp/).

## Requirements
- Silverstripe > 4.2
- PHP 7.1 (IMAGETYPE_WEBP)
- GDLib or imagick with webp Extension


## Installation
If you wish to use this fork, you need to add below under `repositories` in your `composer.json`, before installing.
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/lerni/silverstripe-webp-image"
        }
    ]
}
```
```sh
composer require nomidi/silverstripe-webp-image
```


## Usage
- run `dev/build?flush=1`
- This module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` to force Browser to load webp images as described in the following link [css-tricks.com](https://css-tricks.com/using-webp-images/). If you're running other modules doing so like [`lerni/folderindex`](https://github.com/lerni/folderindex), you'll have to maintain your own version of this template in your project.
- There is a task `dev/tasks/WebpImageGenerationTask` to generate WebP variants for all jpg's & png's in assets (local assets store only). The task should run per CLI `php ./vendor/silverstripe/framework/cli-script.php dev/tasks/WebpImageGenerationTask` as it likely runs longer than `max_execution_time`.
- Also there is `dev/tasks/WebpImagePurgeTask`. This will remove all webP variants, if an original file could be found up on resize naming conventions.


## Test if webp is available
Run `phpinfo()` and check if GD or imagick supports `webp`. You also can check with the snippet below, to see if if webp is available with the installed GD Library. Copy this code into a `.php` file in your webroot and open it per browser.
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
- [ ] fix if webP variants are generated in `.protected` and not directly published. Running `dev/tasks/WebpImageGenerationTask` as cron task kinda circumvents this, but 'll leave artefacts in `.protected` - `dev/tasks/WebpImagePurgeTask` cleans those up.
