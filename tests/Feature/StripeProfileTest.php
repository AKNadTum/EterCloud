<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\StripeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Stripe\StripeClient;

class StripeProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_customer_details_does_not_create_stripe_customer_automatically()
    {
        $user = User::factory()->create(['stripe_customer_id' => null]);

        $stripeClientMock = $this->mock(StripeClient::class);

        $service = new StripeService($stripeClientMock);

        $details = $service->getCustomerDetails($user);

        $this->assertNull($details['customer']);
        $this->assertNull($user->stripe_customer_id);
    }

    public function test_link_stripe_method_creates_stripe_customer()
    {
        $user = User::factory()->create(['stripe_customer_id' => null, 'name' => 'John Doe', 'email' => 'john@example.com']);

        $stripeClientMock = \Mockery::mock(StripeClient::class);
        $stripeClientMock->customers = \Mockery::mock();

        $stripeClientMock->customers->shouldReceive('all')
            ->once()
            ->with(['email' => $user->email, 'limit' => 1])
            ->andReturn((object)['data' => []]);

        $stripeClientMock->customers->shouldReceive('create')
            ->once()
            ->with([
                'email' => $user->email,
                'name' => $user->name,
            ])
            ->andReturn((object)['id' => 'cus_new123']);

        $this->app->instance(StripeClient::class, $stripeClientMock);

        $this->actingAs($user);

        $response = $this->post(route('dashboard.profile.stripe.link'));

        $response->assertRedirect();
        $user->refresh();
        $this->assertEquals('cus_new123', $user->stripe_customer_id);
    }
}
