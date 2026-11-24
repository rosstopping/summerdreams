<?php

namespace App\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class CheckoutQrCode
{
    public static function svg(string $url): string
    {
        $renderer = new ImageRenderer(new RendererStyle(500, 0), new SvgImageBackEnd);

        return (new Writer($renderer))->writeString($url, 'UTF-8');
    }
}
