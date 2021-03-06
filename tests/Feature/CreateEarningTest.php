<?php

namespace Tests\Feature;

use App\Models\Space;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateEarningTest extends TestCase
{
    private $user;
    private $space;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->space = factory(Space::class)->create();
    }

    public function testFailedValidation(): void
    {
        $response = $this
            ->followingRedirects()
            ->actingAs($this->user)
            ->withSession(['space_id' => $this->space->id])
            ->postJson('/earnings', [
                'date' => date('Y-m-d'),
                'description' => 'Something for the test',
                'amount' => '9.999'
            ]);

        $response
            ->assertStatus(422);
    }

    public function testSuccessfulCreation(): void
    {
        $response = $this
            ->followingRedirects()
            ->actingAs($this->user)
            ->withSession(['space_id' => $this->space->id])
            ->postJson('/earnings', [
                'date' => date('Y-m-d'),
                'description' => 'Something for the test',
                'amount' => '9.99'
            ]);

        $response
            ->assertStatus(200);
    }
}
