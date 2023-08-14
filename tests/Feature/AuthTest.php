<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
  use RefreshDatabase;

  /**
    * @test
    * Test login
  */
  public function userCanLogin(): void {
    User::create([
      'name' => 'Caique',
      'email' => 'caique@teste.com',
      'password' => 'password',
    ])->tokens()->create([
      'name' => 'api',
      'token' => hash('sha256', 'N7fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'),
      'abilities' => ['api-access'],
    ]);

    $response = $this->json('POST',route('auth'),[
      'email' => 'caique@teste.com',
      'password' => 'password',
    ]);

    $response->assertStatus(200);
    $this->assertArrayHasKey('token',$response->json());
  }
}
