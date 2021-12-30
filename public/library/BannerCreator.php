<?php

namespace App\Library;

use Imagick;
use App\Library\BannerCreatorConfig as Config;
use ImagickDrawException;
use ImagickException;

class BannerCreator
{
    /**
     * @throws ImagickDrawException
     * @throws ImagickException
     */
    public function generateBanner(
        string $balance
    ): string {
        $layerMethodType = imagick::LAYERMETHOD_COMPARECLEAR;

        $bg = new \Imagick(realpath('assets/bg.jpg'));
        $bg->setImageArtifact('compose:args', "1,0,-0.5,0.5");

        $draw = new \ImagickDraw();
        $draw->setFillColor('#ffffff');

        // Add latest balance
        $draw->setFontSize(120);
        $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
        $draw->setFont('assets/font/Roboto-Bold.ttf');
        $bg->annotateImage($draw, 750, 220, 0, $balance);

        // Add tipping address
        $draw->setFontSize(23);
        $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
        $draw->setFont('assets/font/Roboto-Regular.ttf');
        $bg->annotateImage($draw, 750, 270, 0, $_ENV['LN_ADDRESS']);

        $bg->setImageFormat('jpg');
        $result = $bg->mergeImageLayers($layerMethodType);
        return $result->getImageBlob();
    }
}
