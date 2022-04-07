<?php

namespace Nomidi\Dev\Tasks;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;

class WebpImagePurgeTask extends BuildTask
{

    protected $title = 'Silverstripe purge webp Task';

    protected $description = 'A task for cleaning up webp variants for all (local) images \r\n--- Caution: just use this if you\'re sure webP upload isn\'t allowed';

    private static $segment = 'WebpImagePurgeTask';

    public function run($request)
    {

        echo "\n";

        // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
        $current = dirname(dirname(Director::baseFolder())) . '/current';

        if (is_dir($current)) {
            $path = dirname(dirname(Director::baseFolder())) . '/shared/public/assets/';
            chdir(dirname(dirname(Director::baseFolder())));
        } else {
            $base = Director::baseFolder();
            $path = $base . '/public/assets/';
        }

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        $pwdLength = strlen(getcwd()) + 1;

        foreach($objects as $name => $object){
            if (is_file($name)) {
                if (exif_imagetype($name) == IMAGETYPE_WEBP) {
                    $originalName = $this->guessOriginalName($name);

                    // Check if it's a webp VARIANT - or if there is an original
                    if ($originalName && !is_file($originalName)) {
                        echo($name."\n");
                        unlink(realpath($name));
                    }
                }
            }
        }
    }

    public function guessOriginalName($filename)
    {
        $picname = pathinfo($filename, PATHINFO_FILENAME);
        $directory = pathinfo($filename, PATHINFO_DIRNAME);
        $nameNoExt = $directory . '/' . $picname;
        $origin = false;

        if (str_contains($nameNoExt, '_')) {
            $name = $this->str_lreplace('_', '.', $nameNoExt);
            $info = pathinfo($name);
            $originalExtension =  $info['extension'];
            if (str_contains($nameNoExt, '__')) {
                $name = substr($name, 0, strpos($name, '__')) . '.' . $originalExtension;
            }
        }
        return $name;
    }

    // https://stackoverflow.com/questions/3835636/replace-last-occurrence-of-a-string-in-a-string
    function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}
