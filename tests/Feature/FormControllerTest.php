<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FormControllerTest extends TestCase
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

    public function test_admin_can_create_form(): void
    {
        $payload = [
            'title' => 'Форма 1',
            'position' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.forms.store'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Форма успешно добавлена',
            ]);

        $this->assertDatabaseHas('forms', [
            'title' => 'Форма 1',
        ]);
    }

    public function test_admin_can_update_form(): void
    {
        $form = Form::factory()->create([
            'title' => 'Старая форма',
        ]);

        $payload = [
            'title' => 'Новая форма',
            'position' => 2,
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.forms.update', $form), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Форма успешно обновлена',
            ]);

        $this->assertDatabaseHas('forms', [
            'id' => $form->id,
            'title' => 'Новая форма',
        ]);
    }

    public function test_admin_can_delete_form(): void
    {
        $form = Form::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.forms.destroy', $form));

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Форма успешно удалена',
            ]);

        $this->assertDatabaseMissing('forms', [
            'id' => $form->id,
        ]);
    }
}
