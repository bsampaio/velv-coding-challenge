<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerListingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_locations()
    {
        $response = $this->get('/api/servers/locations');
        $data = $response->json();

        $this->assertIsArray($data);
        $data = collect($data);

        $this->assertTrue($data->some('AmsterdamAMS-01'));
        $response->assertStatus(200);
    }

    public function test_the_application_returns_servers()
    {
        $response = $this->get('/api/servers');
        $data = $response->json();

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $response->assertStatus(200);
    }
}
