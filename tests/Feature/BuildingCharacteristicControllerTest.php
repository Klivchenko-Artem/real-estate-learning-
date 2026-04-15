<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\BuildingCharacteristic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BuildingCharacteristicControllerTest extends TestCase
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

    public function test_admin_can_add_characteristic(): void
    {
        $building = Building::factory()->create();

        $payload = [
            'key'   => 'Высота',
            'value' => '3м',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.buildings.characteristics.store', $building), $payload, ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseHas('building_characteristics', [
            'building_id' => $building->id,
            'key'         => 'Высота',
        ]);
    }

    public function test_admin_can_update_characteristic(): void
    {
        $characteristic = BuildingCharacteristic::factory()->create([
            'key' => 'Ширина',
            'value' => '5м',
        ]);

        $payload = [
            'key'   => 'Ширина',
            'value' => '6м',
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.buildings.characteristics.update', $characteristic), $payload, ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseHas('building_characteristics', [
            'id'    => $characteristic->id,
            'value' => '6м',
        ]);
    }

    public function test_admin_can_delete_characteristic(): void
    {
        $characteristic = BuildingCharacteristic::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.buildings.characteristics.destroy', $characteristic), [], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseMissing('building_characteristics', [
            'id' => $characteristic->id,
        ]);
    }
}
