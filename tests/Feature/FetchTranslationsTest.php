<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FetchTranslationsTest extends TestCase
{
    public function testUsingUnauthorizedUser(): void
    {
        $response = $this->get('/translations');

        $response->assertStatus(302);
    }

    public function testUsingAuthorizedUser(): void
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/translations');

        $response
            ->assertStatus(200)
            ->assertSee('window.i18n');
    }

    public function testUsingDifferentLanguage(): void
    {
        $user = factory(User::class)->create(['language' => 'nl']);

        $response = $this
            ->actingAs($user)
            ->get('/translations');

        $response
            ->assertStatus(200)
            ->assertSeeText('"cancel":"Annuleer"', false);
    }
}
