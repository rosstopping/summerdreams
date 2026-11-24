<?php

namespace Tests\Unit;

use App\Support\CheckoutQrCode;
use PHPUnit\Framework\TestCase;

class CheckoutQrCodeTest extends TestCase
{
    public function test_checkout_links_generate_distinct_500_pixel_svg_codes(): void
    {
        $svg = CheckoutQrCode::svg('https://checkout.stripe.com/c/pay/test-one');
        $xml = simplexml_load_string($svg);

        $this->assertNotFalse($xml);
        $this->assertSame('svg', $xml->getName());
        $this->assertSame('500', (string) $xml['width']);
        $this->assertSame('500', (string) $xml['height']);
        $this->assertNotSame($svg, CheckoutQrCode::svg('https://checkout.stripe.com/c/pay/test-two'));
    }
}
