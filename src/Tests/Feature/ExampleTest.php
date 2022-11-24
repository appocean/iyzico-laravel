<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Rinvex\Subscriptions\Models\Plan;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_subscription_plan()
    {
        $this->createADefaultPlan();
        $this->assertDatabaseHas('plans', [
            'slug' => 'vip-for-3-months'
        ]);
        $this->assertTrue(true);
    }

    public function test_the_plan_should_have_a_subscription()
    {
        $this->createADefaultPlan();
        $plan = Plan::first();
        $this->assertNotNull($plan);
        $this->assertTrue(count($plan->subscriptions) > 0);
    }

    public function test_create_a_subscription()
    {
        $user = factory(User::class)->create();
        $plan = $this->createADefaultPlan();
        $user->newSubscription('main', $plan);
        $this->assertTrue(count($plan->subscriptions) > 0);
        $this->assertTrue(true);
    }

    private function createADefaultPlan()
    {
        $plan = new Plan();
        $plan->name = 'VIP for 3 months';
        $plan->slug = 'vip-for-3-months';
        $plan->description = 'test description';
        $plan->price = 12.99;
        $plan->currency = 'USD';
        $plan->signup_fee = 0;
        $plan->invoice_period = 1;
        $plan->invoice_interval = 'month';
        $plan->trial_period = 2;
        $plan->trial_interval = 'day';
        $plan->sort_order = 1;
        $plan->save();
        return $plan;
    }
}
