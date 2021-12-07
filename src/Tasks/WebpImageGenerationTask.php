<?php

namespace Nomidi\Dev\Tasks;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use Intervention\Image\ImageManagerStatic as Image;

class WebpImageGenerationTask extends BuildTask
{

    protected $title = 'SilverStripe generating webp Task';

    protected $description = 'A task for generating webp variants for all (local) images';

    private static $segment = 'WebpImageGenerationTask';

    private static $webp_quality = 80;

    public function run($request)
    {

        $webp_quality = $this->config()->webp_quality;

        echo "\n";

        // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
        $current = dirname(dirname(Director::baseFolder())) . '/current';
        if (is_dir($current)) {
            $base = dirname(dirname(Director::baseFolder())) . '/shared';
        } else {
            $base = Director::baseFolder();
        }
        $path = $base . '/public/assets/';

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
        $pwdLeght = strlen(getcwd()) + 1;

        foreach($objects as $name => $object){
            if (is_file($name)) {
                $detectedType = exif_imagetype($name);
                if (in_array($detectedType, $allowedTypes) ) {
                    $relativeName = substr($name, $pwdLeght);
                    echo "$relativeName\n";
                    $img = Image::make($relativeName);
                    $img->save($this->createWebPName($relativeName), $webp_quality, 'webp');
                    $img->destroy();
                    gc_collect_cycles();

                    echo ($this->createWebPName($relativeName) ."\n\n");
                }
            }
        }
    }

    public function createWebPName($filename)
    {
        $picname = pathinfo($filename, PATHINFO_FILENAME);
        $directory = pathinfo($filename, PATHINFO_DIRNAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        return $directory.'/'.$picname.'_'.$extension.'.webp';
    }
}
