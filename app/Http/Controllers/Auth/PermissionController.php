<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

class PermissionController extends Controller
{
    use AuthenticatesUsers;

    protected function defineScope(Request $request)
    {
        $user = User::where('email', $request->username)->get();
        $role = $user[0]->role;
        if ($role == 'ROLE_ADMIN') {
            $request->request->add([
                'scope' => 'ROLE_ADMIN'
            ]);
        } else {
            $request->request->add([
                'scope' => 'ROLE_USER'
            ]);
        }
        $tokenRequest = Request::create(
            '/oauth/token',
            'post'
        );
        return Route::dispatch($tokenRequest);
    }
}
