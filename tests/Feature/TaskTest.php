<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
  use RefreshDatabase;

  /**
    * @test
    * Test Create Task
    */
  public function userCanCreateTask(): void {
    $this->createUser();
    $token = $this->auth();

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('POST','/api/tasks/',[
      'title' => 'Teste',
      'description' => 'Lorem Ipsum!',
      'status' => 'pendente'
    ]);

    $response->assertStatus(200);
    $this->assertArrayHasKey('task',$response->json());
  }

  /**
    * @test
    * Test View Tasks
    */
  public function userCanSeeTasks() {
    $this->createUser();
    $token = $this->auth();

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('POST','/api/tasks/',[
      'title' => 'Teste',
      'description' => 'Lorem Ipsum!',
      'status' => 'pendente'
    ]);

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('GET','/api/tasks/');

    $response->assertStatus(200);
  }

  /**
    * @test
    * Test View Single Task
    */
  public function userCanSeeSingleTask() {
    $this->createUser();
    $token = $this->auth();

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('POST','/api/tasks/',[
      'title' => 'Teste',
      'description' => 'Lorem Ipsum!',
      'status' => 'pendente'
    ]);

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('GET','/api/tasks/1');

    $response->assertStatus(200);
    $this->assertArrayHasKey('task',$response->json());
  }

  /**
    * @test
    * Test Edit Task
    */
  public function userCanEditTask() {
    $this->createUser();
    $token = $this->auth();

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('POST','/api/tasks/',[
      'title' => 'Teste',
      'description' => 'Lorem Ipsum!',
      'status' => 'pendente'
    ]);

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('PUT','/api/tasks/1',[
      'status' => 'concluido'
    ]);

    $response->assertStatus(200);
    $this->assertArrayHasKey('task',$response->json());
  }

  /**
    * @test
    * Test Delete Task
    */
  public function userCanDeleteTask() {
    $this->createUser();
    $token = $this->auth();

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('POST','/api/tasks/',[
      'title' => 'Teste',
      'description' => 'Lorem Ipsum!',
      'status' => 'pendente'
    ]);

    $response = $this->withHeaders([
      'Authorization' => 'Bearer '. $token,
    ])->json('DELETE','/api/tasks/1');

    $response->assertStatus(200);
  }

  private function createUser() {
    User::create([
      'name' => 'Caique',
      'email' => 'caique@teste.com',
      'password' => 'password',
    ])->tokens()->create([
      'name' => 'api',
      'token' => hash('sha256', 'N7fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'),
      'abilities' => ['api-access'],
    ]);
  }

  private function auth() {
    $response = $this->json('POST','/api/auth',[
      'email' => 'caique@teste.com',
      'password' => 'password',
    ]);

    return $response['token'];
  }
}
