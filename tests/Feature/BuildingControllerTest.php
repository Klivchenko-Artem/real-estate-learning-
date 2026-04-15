<?php

namespace Tests\Feature;

use App\Enums\BuildingType;
use App\Models\Building;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BuildingControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_create_house_building(): void
    {
        $payload = [
            'title' => 'Тестовый дом',
            'alias' => 'test-house',
            'price_from' => '100000',
            'submit' => 'close',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.house.store'), $payload);

        $response->assertStatus(302);

        $this->assertDatabaseHas('buildings', [
            'alias' => 'test-house',
            'title' => 'Тестовый дом',
            'type'  => BuildingType::HOUSE,
        ]);
    }

    public function test_admin_can_update_house_building(): void
    {
        $building = Building::factory()->create([
            'type'  => BuildingType::HOUSE,
            'title' => 'Старый заголовок',
            'alias' => 'old-house',
        ]);

        $payload = [
            'title' => 'Новый дом',
            'alias' => 'new-house',
            'price_from' => '120000',
            'submit' => 'close',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.house.update', $building), $payload);

        $response->assertStatus(302);

        $this->assertDatabaseHas('buildings', [
            'id'    => $building->id,
            'title' => 'Новый дом',
            'alias' => 'new-house',
        ]);
    }

    public function test_admin_can_delete_house_building(): void
    {
        $building = Building::factory()->create(['type' => BuildingType::HOUSE]);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.house.destroy', $building), [], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseMissing('buildings', [
            'id' => $building->id,
        ]);
    }
}
