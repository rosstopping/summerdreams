<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Package;
use App\Models\SeasonalPricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonalPricingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that seasonal pricing is correctly applied to package amount
     */
    public function test_package_uses_seasonal_pricing_for_date(): void
    {
        // Create a package
        $package = Package::create([
            'name' => 'Test Package',
            'amount' => 100.00, // Default amount
            'deposit' => 50.00, // Default deposit
            'currency' => 'GBP',
        ]);

        // Create seasonal pricing
        $seasonalPricing = SeasonalPricing::create([
            'package_id' => $package->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-08-31',
            'amount' => 150.00, // Summer pricing
            'deposit' => 75.00, // Summer deposit
        ]);

        // Test that seasonal pricing is used for a date within the range
        $summerAmount = $package->getAmountForDate('2026-07-15');
        $this->assertEquals(150.00, $summerAmount);

        $summerDeposit = $package->getDepositForDate('2026-07-15');
        $this->assertEquals(75.00, $summerDeposit);

        // Test that default pricing is used for a date outside the range
        $winterAmount = $package->getAmountForDate('2026-12-15');
        $this->assertEquals(100.00, $winterAmount);

        $winterDeposit = $package->getDepositForDate('2026-12-15');
        $this->assertEquals(50.00, $winterDeposit);
    }

    /**
     * Test that seasonal pricing without deposit uses default
     */
    public function test_package_uses_default_deposit_when_seasonal_has_none(): void
    {
        $package = Package::create([
            'name' => 'Test Package',
            'amount' => 100.00,
            'deposit' => 50.00,
            'currency' => 'GBP',
        ]);

        SeasonalPricing::create([
            'package_id' => $package->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-08-31',
            'amount' => 150.00,
            'deposit' => null, // No seasonal deposit
        ]);

        $deposit = $package->getDepositForDate('2026-07-15');
        $this->assertEquals(50.00, $deposit); // Should use default
    }

    /**
     * Test that booking calculations use seasonal pricing
     */
    public function test_booking_calculations_use_seasonal_pricing(): void
    {
        // Create a package
        $package = Package::create([
            'name' => 'Test Package',
            'amount' => 100.00,
            'deposit' => 50.00,
            'currency' => 'GBP',
        ]);

        // Create seasonal pricing
        SeasonalPricing::create([
            'package_id' => $package->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-08-31',
            'amount' => 150.00,
            'deposit' => 75.00,
        ]);

        // Create a booking with arrival date in seasonal period
        $booking = Booking::create([
            'site' => 'Test Site',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'mobile' => '1234567890',
            'arrival_date' => '2026-07-15',
            'guests' => 2,
        ]);

        $booking->packages()->attach($package->id);
        $booking->refresh();

        // Amount should be seasonal amount * guests
        $expectedAmount = 150.00 * 2; // 300.00
        $this->assertEquals($expectedAmount, $booking->amount);

        // Deposit should be seasonal deposit * guests
        $expectedDeposit = 75.00 * 2; // 150.00
        $this->assertEquals($expectedDeposit, $booking->deposit);
    }

    /**
     * Test seasonal pricing isActiveForDate method
     */
    public function test_seasonal_pricing_is_active_for_date(): void
    {
        $package = Package::create([
            'name' => 'Test Package',
            'amount' => 100.00,
            'deposit' => 50.00,
            'currency' => 'GBP',
        ]);

        $seasonalPricing = SeasonalPricing::create([
            'package_id' => $package->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-08-31',
            'amount' => 150.00,
            'deposit' => 75.00,
        ]);

        // Test dates within range
        $this->assertTrue($seasonalPricing->isActiveForDate('2026-06-01'));
        $this->assertTrue($seasonalPricing->isActiveForDate('2026-07-15'));
        $this->assertTrue($seasonalPricing->isActiveForDate('2026-08-31'));

        // Test dates outside range
        $this->assertFalse($seasonalPricing->isActiveForDate('2026-05-31'));
        $this->assertFalse($seasonalPricing->isActiveForDate('2026-09-01'));
    }

    /**
     * Test getForPackageAndDate static method
     */
    public function test_get_for_package_and_date(): void
    {
        $package = Package::create([
            'name' => 'Test Package',
            'amount' => 100.00,
            'deposit' => 50.00,
            'currency' => 'GBP',
        ]);

        $seasonalPricing = SeasonalPricing::create([
            'package_id' => $package->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-08-31',
            'amount' => 150.00,
            'deposit' => 75.00,
        ]);

        // Should find seasonal pricing for date in range
        $found = SeasonalPricing::getForPackageAndDate($package->id, '2026-07-15');
        $this->assertNotNull($found);
        $this->assertEquals($seasonalPricing->id, $found->id);

        // Should return null for date outside range
        $notFound = SeasonalPricing::getForPackageAndDate($package->id, '2026-12-15');
        $this->assertNull($notFound);
    }
}
