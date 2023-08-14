<?php

namespace App\Http\Controllers;

use App\Http\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
  protected $taskService;

  public function __construct() {
    $this->taskService = new TaskService;
  }

  public function index() {
    return $this->taskService->index();
  }

  public function store(Request $request) {
    return $this->taskService->create($request);
  }

  public function show($id) {
    return $this->taskService->show($id);
  }

  public function update(Request $request, $id) {
    return $this->taskService->update($request, $id);
  }

  public function destroy($id) {
    return $this->taskService->delete($id);
  }
}
