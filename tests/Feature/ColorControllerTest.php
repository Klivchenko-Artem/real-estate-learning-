<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ColorControllerTest extends TestCase
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

    public function test_admin_can_create_color(): void
    {
        $payload = [
            'title' => 'Красный',
            'code'  => '#ff0000',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.colors.store'), $payload, ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Цвет успешно добавлен',
            ]);

        $this->assertDatabaseHas('colors', [
            'title' => 'Красный',
            'code'  => '#ff0000',
        ]);
    }

    public function test_admin_can_update_color(): void
    {
        $color = Color::factory()->create([
            'title' => 'Синий',
            'code'  => '#0000ff',
        ]);

        $payload = [
            'title' => 'Зелёный',
            'code'  => '#00ff00',
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.colors.update', $color), $payload, ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Цвет успешно обновлен',
            ]);

        $this->assertDatabaseHas('colors', [
            'id'    => $color->id,
            'title' => 'Зелёный',
            'code'  => '#00ff00',
        ]);
    }

    public function test_admin_can_delete_color(): void
    {
        $color = Color::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.colors.destroy', $color));

        $response->assertStatus(200)
            ->assertJson([
                'status'  => true,
                'message' => 'Запись успешно удалена',
            ]);

        $this->assertDatabaseMissing('colors', [
            'id' => $color->id,
        ]);
    }
}
