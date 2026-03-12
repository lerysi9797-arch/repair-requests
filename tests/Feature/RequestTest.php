<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RequestTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    /** @test */
    public function user_can_create_request()
    {
        $response = $this->post('/', [
            'client_name' => 'Тестовый клиент',
            'phone' => '+79991234567',
            'address' => 'ул. Тестовая, д. 1',
            'problem_text' => 'Не работает кран',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('requests', [
            'client_name' => 'Тестовый клиент',
            'status' => 'new',
        ]);
    }

    /** @test */
    public function race_condition_on_take()
    {
        $master = User::factory()->create(['role' => 'master']);

        $request = Request::factory()->create([
            'status' => 'new',
        ]);

        $request->update([
            'assigned_to' => $master->id,
            'status' => 'assigned'
        ]);

        $response1 = $this->actingAs($master)
            ->patch("/requests/{$request->id}/take");

        $response2 = $this->actingAs($master)
            ->patch("/requests/{$request->id}/take");

        $response1->assertStatus(302);
        $response2->assertStatus(409);
    }
}
