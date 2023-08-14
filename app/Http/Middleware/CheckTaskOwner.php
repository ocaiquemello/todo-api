<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class CheckTaskOwner
{
  /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
  public function handle(Request $request, Closure $next): Response {
    if(Auth::user()){
      $user_id = Auth::user()->id;
      $task_id = $request->route('id');

      if(Task::where([
        ['user_id', $user_id],
        ['id', $task_id]
      ])->exists()) {
        return $next($request);
      }

      abort(403, 'Usuário não possui acesso a essa Task!');
    }
    abort(403, 'Usuário não está logado!');
  }
}
