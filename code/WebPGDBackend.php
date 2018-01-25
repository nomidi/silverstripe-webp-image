<?php
class WebPGDBackend extends GDBackend
{
    private static $webp_default_quality = 80;

    public function __construct($filename = null, $args = array())
    {
        parent::__construct($filename, $args);
        $this->webp_quality = $this->config()->webp_default_quality;
    }

    public function writeTo($filename)
    {
        parent::writeTo($filename);

        if (function_exists('imagewebp')) {
            list($width, $height, $type, $attr) = getimagesize($filename);
            switch ($type) {
              case 2:
                  if (function_exists('imagecreatefromjpeg')) {
                      $img = imagecreatefromjpeg($filename);
                      $webp = imagewebp($img, $this->createWebPName($filename), $this->webp_quality);
                  }
                  break;
              case 3:
                  if (function_exists('imagecreatefrompng')) {
                      $img = imagecreatefrompng($filename);
                      imagesavealpha($img, true); // save alphablending setting (important)
                      $webp = imagewebp($img, $this->createWebPName($filename), $this->webp_quality);
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
