<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function loadUsers($rows) 
    {
        $users = User::paginate($rows);
        return response()->json($users, 200);
    }
    
    public function getUser($id) 
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }
    
    public function searchUsers(Request $request) 
    {
        $search = $request->search;
        $result = User::where('username', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")->get();
        return response()->json($result, 200);
    }

    public function saveUser(Request $request) 
    {
        $this->validateRequest($request);
        $user = User::create($this->filterData($request));
        return response()->json($user, 201);
    }
    
    public function editUser($id, Request $request) 
    {
        $user = User::findOrFail($id);
        $user->update($this->filterData($request));
        return response()->json($user, 200);
    }
    
    public function deleteUser($id) 
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json($user, 200);
    }

    public function validateRequest(Request $request) 
    {
        return $request->validate([
            'username' => 'bail|required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);
    }

    public function filterData(Request $request)
    {
        $token = $request->input('api_token');
        return [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'api_token' => $token ? $token : 'n0t0k3n'
        ];
    }
}
