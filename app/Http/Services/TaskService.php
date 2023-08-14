<?php

namespace App\Http\Services;

use App\Http\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Exception;

class TaskService
{
  protected $taskRepository;

  public function __construct() {
    $this->taskRepository = new TaskRepository;;
  }

  public function index() {
    return $this->taskRepository->fetch();
  }

  public function create(Request $request) {
    try {
      $data = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'status' => 'required'
      ]);

      $data = $request->only(['title', 'description', 'status']);
      $data['user_id'] = auth()->user()->id;

      $task = $this->taskRepository->create($data);
      return response()->json([
        'status' => true,
        'message' => 'Task criada com sucesso!',
        'task' => $task
      ], 200);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function show($id) {
    try {
      $task = $this->taskRepository->fetchSingleTask($id);

      return response()->json([
        'status' => true,
        'message' => 'Task encontrada com sucesso!',
        'task' => $task
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function update(Request $request, $id) {
    try {
      $data = $request->only(['title', 'description', 'status']);
      $task = $this->taskRepository->update($id, $data);

      return response()->json([
        'status' => true,
        'message' => 'Task atualizada com sucesso!',
        'task' => $task
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function delete($id) {
    try {
      $this->taskRepository->delete($id);

      return response()->json([
        'status' => true,
        'message' => 'Task deletada com sucesso!'
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
