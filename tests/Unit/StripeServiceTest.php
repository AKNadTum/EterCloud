<?php

namespace Tests\Unit;

use App\Services\StripeService;
use PHPUnit\Framework\TestCase;
use Stripe\StripeClient;
use Mockery;

class StripeServiceTest extends TestCase
{
    public function test_format_price_labels_returns_gratuit_for_zero_amount()
    {
        $stripeMock = Mockery::mock(StripeClient::class);
        $service = new StripeService($stripeMock);

        $details = [
            'id' => 'price_123',
            'currency' => 'EUR',
            'unit_amount' => 0,
            'amount' => 0.0,
            'recurring' => [
                'interval' => 'month',
                'interval_count' => 1,
            ],
        ];

        $labels = $service->formatPriceLabels($details);

        $this->assertEquals('Gratuit', $labels['price']);
        $this->assertNull($labels['period']);
    }

    public function test_format_price_labels_returns_formatted_price_for_non_zero_amount()
    {
        $stripeMock = Mockery::mock(StripeClient::class);
        $service = new StripeService($stripeMock);

        $details = [
            'id' => 'price_123',
            'currency' => 'EUR',
            'unit_amount' => 990,
            'amount' => 9.9,
            'recurring' => [
                'interval' => 'month',
                'interval_count' => 1,
            ],
        ];

        $labels = $service->formatPriceLabels($details);

        $this->assertEquals('9,90 €', $labels['price']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
