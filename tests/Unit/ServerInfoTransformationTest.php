<?php

namespace Tests\Unit;

use App\Http\Controllers\ServersController;
use Tests\TestCase;

class ServerInfoTransformationTest extends TestCase
{
    protected $serversController;

    public function setUp(): void
    {
        parent::setUp();

        $this->serversController = new ServersController();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_source_exists()
    {
        $file = $this->serversController->getSourceFile();

        $this->assertNotNull($file);
    }

    public function test_can_transform_data()
    {
        $rows = $this->serversController->getTransformedData();

        $this->assertNotEmpty($rows);
    }
}
