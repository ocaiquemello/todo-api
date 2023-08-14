<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserService
{
  protected $userRepository;

  public function __construct() {
    $this->userRepository = new UserRepository;;
  }

  public function auth(Request $request) {
    try {
      $validateUser = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if($validateUser->fails()){
        return response()->json([
          'status' => false,
          'message' => 'Erro na validação.',
          'errors' => $validateUser->errors()
        ], 401);
      }

      if(!Auth::attempt($request->only(['email', 'password']))){
        return response()->json([
          'status' => false,
          'message' => 'E-mail e Senha incorretos!',
        ], 401);
      }

      $user = $this->userRepository->fetchUser($request->email);

      return response()->json([
        'status' => true,
        'message' => 'Usuário logado com sucesso!',
        'token' => $user->createToken("API TOKEN")->plainTextToken
      ], 200);

    } catch (\Throwable $th) {
      return response()->json([
        'status' => false,
        'message' => $th->getMessage()
      ], 500);
    }
  }
}
