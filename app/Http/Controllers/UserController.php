<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function profile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }

        return response()->json($user);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'success',
            $user,
        );
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        return response()->json(
            'message' => 'success',
            $user,
        );
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'success',
            $user,
        ]);
    }
}
