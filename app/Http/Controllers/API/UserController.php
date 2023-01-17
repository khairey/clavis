<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //validator
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['username'] = $user->username;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User Created Sucessfully'
        ];

        return response()->json($response, 200);
    }

    public function index()
    {
        $users = User::all();
        return response()->json([
            $users
        ]);
    }

    public function update(Request $request,User $user)
    {
        $user->update($request->all());
        return response()->json([
            $user
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            $user
        ]);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'deleted']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'something went wrong'], 400);
        }
    }
}
