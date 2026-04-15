<?php

namespace Tests\Feature;

use App\Models\CatalogCharacteristic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CatalogCharacteristicControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'admin']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_create_catalog_characteristic(): void
    {
        $payload = [
            'key' => 'test_key',
            'value' => 'Some value',
            'type' => 'warm_contour',
            'building_type' => 'HOUSE',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.catalog.characteristics.store'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Характеристика успешно добавлена',
            ]);

        $this->assertDatabaseHas('catalog_characteristics', [
            'key'   => 'test_key',
            'value' => 'Some value',
        ]);
    }

    public function test_admin_can_update_catalog_characteristic(): void
    {
        $characteristic = CatalogCharacteristic::factory()->create([
            'key' => 'old_key',
            'value' => 'Old value',
        ]);

        $payload = [
            'key' => 'new_key',
            'value' => 'New value',
            'type' => $characteristic->type,
            'building_type' => $characteristic->building_type,
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.catalog.characteristics.update', $characteristic), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Характеристика успешно обновлена',
            ]);

        $this->assertDatabaseHas('catalog_characteristics', [
            'id'    => $characteristic->id,
            'key'   => 'new_key',
            'value' => 'New value',
        ]);
    }

    public function test_admin_can_delete_catalog_characteristic(): void
    {
        $characteristic = CatalogCharacteristic::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.catalog.characteristics.destroy', $characteristic));

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Характеристика успешно удалена',
            ]);

        $this->assertDatabaseMissing('catalog_characteristics', [
            'id' => $characteristic->id,
        ]);
    }
}
