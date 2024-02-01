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
            'User_name' => 'required|string|max:255',
            'Email' => 'required|email|unique:users',
            'Password' => 'required|string|min:6',
        ];

        // Custom error messages
        $messages = [
            'User_name.required' => 'User name is required.',
            'Email.required' => 'Email is required.',
            'Email.email' => 'Invalid email format.',
            'Email.unique' => 'Email is already taken.',
            'Password.required' => 'Password is required.',
            'Password.min' => 'Password must be at least 6 characters.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the user
        $user = new User();
        $user->User_name = $request->User_name;
        $user->Email = $request->Email;
        $user->Password = bcrypt($request->Password); // Hash the password for security
        $user->save();

        return $user;
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
            'User_name' => 'string|max:255',
            'Email' => 'email|unique:users',
            'Password' => 'string|min:6',
        ];

        // Custom error messages
        $messages = [
            'User_name.string' => 'User name must be a string.',
            'User_name.max' => 'User name must not exceed 255 characters.',
            'Email.email' => 'Invalid email format.',
            'Email.unique' => 'Email is already taken.',
            'Password.string' => 'Password must be a string.',
            'Password.min' => 'Password must be at least 6 characters.',
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
        $user->User_name = $request->input('User_name', $user->User_name);
        $user->Email = $request->input('Email', $user->Email);
        
        if ($request->has('Password')) {
            $user->Password = bcrypt($request->Password); // Hash the updated password
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
