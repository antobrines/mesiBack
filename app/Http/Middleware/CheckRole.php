<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $data = [
            "message" => "Vous n'êtes pas identifié"
        ];
        if ($request->user() === null) {
            return response()->json($data, 401);
        }
        // $actions = $request->route()->getAction();
        // $roles = isset($actions["roles"]) ? $actions["roles"] : null;
        $data = [
            "message" => "Vous ne disposez pas des droits nécessaires"
        ];
        if ($request->user()->hasAnyRoles($roles) || !$roles) {
            return $next($request);
        }
        return response()->json($data, 401);
    }
}
