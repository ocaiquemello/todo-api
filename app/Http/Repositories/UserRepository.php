<?php

namespace App\Http\Repositories;

use App\Models\User;
use Exception;

class UserRepository
{
  public function fetchUser($email) {
    try {
      return User::where('email', $email)->first();
    } catch (Exception $e) {
      report($e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
