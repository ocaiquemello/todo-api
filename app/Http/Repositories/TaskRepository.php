<?php

namespace App\Http\Repositories;

use App\Models\Task;
use Exception;

class TaskRepository
{
  public function fetch() {
    try {
      return Task::where('user_id', auth()->user()->id)->get();
    } catch (Exception $e) {
      report($e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function create($data) {
    try {
      return Task::create($data);
    } catch (Exception $e) {
      report($e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function fetchSingleTask($id) {
    try {
      return Task::where('id', $id)->first();
    } catch (Exception $e) {
      report($e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function update($id, $data) {
    try {
      $task = Task::where('id', $id)->update($data);
      $task = Task::find($id);

      return $task;
    } catch (Exception $e) {
      report($e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }

  public function delete($id) {
    try {
      return Task::where('id', $id)->delete();
    } catch (Exception $e) {
      report($e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
