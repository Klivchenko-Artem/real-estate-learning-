<?php

namespace Tests\Feature;

use App\Models\BuildingForm;
use App\Models\BuildingFormColor;
use App\Models\Color;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BuildingFormColorControllerTest extends TestCase
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

    public function test_admin_can_add_color_to_building_form(): void
    {
        $buildingForm = BuildingForm::factory()->create();
        $color = Color::factory()->create();

        $payload = [
            'building_form_id' => $buildingForm->id,
            'color_id' => $color->id,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.buildings.form-colors.store'), $payload, ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseHas('building_form_colors', [
            'building_form_id' => $buildingForm->id,
            'color_id' => $color->id,
        ]);
    }

    public function test_admin_can_delete_building_form_color(): void
    {
        $formColor = BuildingFormColor::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.buildings.form-colors.destroy', $formColor), [], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseMissing('building_form_colors', [
            'id' => $formColor->id,
        ]);
    }
}
