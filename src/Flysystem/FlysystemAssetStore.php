<?php


namespace Nomidi\WebPCreator\Flysystem;

use SilverStripe\Assets\Flysystem\FlysystemAssetStore as SS_FlysystemAssetStore;

class FlysystemAssetStore extends SS_FlysystemAssetStore
{
    private static $webp_default_quality = 80;

    // The path, relative to your web root, to the cwebp binary.
    private static $cwebp_path = 'webp/bin/cwebp';

    public function __construct()
    {
        $this->webp_quality = $this->config()->webp_default_quality;
        $this->cwebp = BASE_PATH . '/' . $this->config()->cwebp_path;
    }


    public function setFromString($data, $filename, $hash = null, $variant = null, $config = array())
    {
        $fileID = $this->getFileID($filename, $hash);
        if ($this->getPublicFilesystem()->has($fileID)) {
            if ($filename) {
                $extension = substr(strrchr($filename, '.'), 1);
                $tmp_file  = TEMP_PATH . DIRECTORY_SEPARATOR . 'raw_' . uniqid() . '.' . $extension;
                file_put_contents($tmp_file, $data);
                $this->createWebPImage($tmp_file, $filename, $hash, $variant, $config);
            }
        }
        return parent::setFromString($data, $filename, $hash, $variant, $config);
    }





    public function setFromLocalFile($path, $filename = null, $hash = null, $variant = null, $config = array())
    {
        if ($filename) {
            if (isset($config['visibility']) && $config['visibility'] === self::VISIBILITY_PROTECTED) {
                //todo: generate protected webp image
            } else {
                $this->createWebPImage($path, $filename, $hash, $variant, $config);
            }
        }

        // Submit to conflict check
        return parent::setFromLocalFile($path, $filename, $hash, $variant, $config);
    }

    public function createWebPImage($path, $filename, $hash, $variant = false)
    {
        if (function_exists('imagewebp') && function_exists('imagecreatefromjpeg') && function_exists('imagecreatefrompng')) {
            $orgpath = './'.$this->getAsURL($filename, $hash, $variant);



            list($width, $height, $type, $attr) = getimagesize($path);

            switch ($type) {
                case 2:
                    $img = imagecreatefromjpeg($path);
                    imagewebp($img, $this->createWebPName($orgpath), $this->webp_quality);
                    break;
                case 3:
                    $img = imagecreatefrompng($path);
                    imagesavealpha($img, true); // save alphablending setting (important)
                    imagewebp($img, $this->createWebPName($orgpath), $this->webp_quality);

            }
            imagedestroy($img);

        } else if (file_exists($this->cwebp)) {
            // Using local cwebp binary method.
            $cwebp = $this->cwebp;
            $q = $this->webp_quality;
            $orgpath = './'.$this->getAsURL($filename, $hash, $variant);
            $webp_path = $this->createWebPName($orgpath);

            exec("$cwebp -q $q $path -o $webp_path");
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
