<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Reminder;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RemindersControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    /** @test */
    public function it_can_create_a_reminder()
    {
        $data = [
            'title' => 'Meeting with Bob',
            'description' => 'Discuss about new project related to new system',
            'remind_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'event_at' => Carbon::now()->addDays(2)->format('Y-m-d H:i:s'),
        ];
        $response = $this->postJson('/api/reminders', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Reminder created successfully',
                'data' => $data,
            ]);

        $this->assertDatabaseHas('reminders', $data);
    }

    /** @test */
    public function it_requires_title_remind_at_and_event_at_fields()
    {
        $response = $this->postJson('/api/reminders', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'error' => [
                    'title', 'remind_at', 'event_at'
                ]
            ]);
    }
}
