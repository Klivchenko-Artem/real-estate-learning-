<?php

namespace Tests\Unit;

use App\Enums\BuildingType;
use App\Models\Building;
use App\Services\BuildingMediaService;
use App\Services\BuildingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class BuildingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BuildingMediaService $mediaMock;
    protected BuildingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mediaMock = Mockery::mock(BuildingMediaService::class);
        $this->app->instance(BuildingMediaService::class, $this->mediaMock);

        $this->service = $this->app->make(BuildingService::class);
    }

    public function test_it_copies_building_and_related_data(): void
    {
        $building = Building::factory()->create([
            'title' => 'Дом',
            'alias' => 'house-1',
            'type'  => BuildingType::HOUSE->value,
        ]);


        $this->mediaMock->shouldReceive('saveMedia')->andReturnNull();
        $this->mediaMock->shouldReceive('saveFinishingSlides')->andReturnNull();

        $response = $this->service->copyBuilding($building, BuildingType::HOUSE);


        $this->assertTrue($response->getData()->status);

        $responseData = (array) $response->getData()->data;
        $this->assertDatabaseHas('buildings', [
            'id'    => $responseData['id'],
            'title' => 'Дом (копия)'
        ]);
    }
}
