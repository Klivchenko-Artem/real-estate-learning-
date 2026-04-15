<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\BuildingForm;
use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BuildingFormControllerTest extends TestCase
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

    public function test_admin_can_add_form_to_building(): void
    {
        $building = Building::factory()->create();
        $form = Form::factory()->create();

        $payload = [
            'building_id' => $building->id,
            'form_id' => $form->id,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.buildings.forms.store'), $payload, ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseHas('building_forms', [
            'building_id' => $building->id,
            'form_id' => $form->id,
        ]);
    }

    public function test_admin_can_delete_building_form(): void
    {
        $building = Building::factory()->create();
        $form = Form::factory()->create();

        $storeResponse = $this->actingAs($this->admin)
            ->postJson(route('admin.buildings.forms.store'), [
                'building_id' => $building->id,
                'form_id'     => $form->id,
            ], ['X-Requested-With' => 'XMLHttpRequest']);

        $storeResponse->assertStatus(200);

        $buildingFormId = $storeResponse->json('buildingForm.id');

        $buildingForm = BuildingForm::findOrFail($buildingFormId);

        $deleteResponse = $this->actingAs($this->admin)
            ->deleteJson(route('admin.building-forms.destroy', $buildingForm), [], ['X-Requested-With' => 'XMLHttpRequest']);

        $deleteResponse->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseMissing('building_forms', [
            'id' => $buildingFormId,
        ]);
    }
}
