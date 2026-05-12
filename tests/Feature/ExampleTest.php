<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Root URL redirects unauthenticated traffic to the admin dashboard.
     */
    public function test_root_redirects_to_admin_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Health-check endpoint provided by Laravel itself stays reachable.
     */
    public function test_health_endpoint_is_reachable(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }
}
