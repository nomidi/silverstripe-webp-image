<?php

class WebPGDTest extends SapphireTest
{
    public static $filenames = array(
        'gif' => 'test_gif.gif',
        'jpg' => 'test_jpg.jpg',
        'png32' => 'test_png.png'
    );


    public function testWriteTo()
    {
        if (function_exists('imagewebp')) {
            $gds = array();
            foreach (self::$filenames as $type => $file) {
                $fullPath = dirname(__FILE__) . '/images/' . $file;
                $testImage = imagecreatetruecolor(100, 100);
                $gd = new WebPGDBackend($fullPath);
                $gd->setImageResource($testImage);
                $gd->writeTo($fullPath);
                $webpImage = $gd->createWebPName($fullPath);
                if ($type != 'gif') {
                    $this->assertTrue(file_exists($webpImage), "Can't find webp Image for type {$type}.");
                    unlink($webpImage);
                } else {
                    $this->assertFalse(file_exists($webpImage), "Found webp Image for type {$type} which should not exist.");
                }
            }
        } else {
            print "GDLib is not enabled with webp support.";
        }
    }

    public function testCreateWebPName()
    {
        $testImagePath = 'image/test.jpg';
        $gd = new WebPGDBackend();
        $webpImage = $gd->createWebPName($testImagePath);
        $this->assertTrue($webpImage=='image/test_jpg.webp', "Failed to create webp image name.");
    }
}
