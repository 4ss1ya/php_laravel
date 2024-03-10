<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Create
    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ];

        // Custom error messages
        $messages = [
            'user_name.required' => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the user
        $user = new User();
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Hash the password for security
        $user->save();

        return $user;
        //return response()->json(['user' => $user], 201);
    }

    // Read
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return $user;
    }

    public function userList()
    {
        return User::all();
    }

    // Update
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'user_name' => 'string|max:255',
            'email' => 'email|unique:users',
            'password' => 'string|min:6',
        ];

        // Custom error messages
        $messages = [
            'user_name.string' => 'User name must be a string.',
            'user_name.max' => 'User name must not exceed 255 characters.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email is already taken.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 6 characters.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update user attributes with request data
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        
        if ($request->has('Password')) {
            $user->password = bcrypt($request->password); // Hash the updated password
        }

        $user->save();

        return $user;
    }

    // Delete
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
