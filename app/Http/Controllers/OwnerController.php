<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    // Create
    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'User_id' => 'required|exists:users,id',
            'User_full_name' => 'required|string|max:255',
            'Course_id' => 'required|exists:courses,id',
        ];

        // Custom error messages
        $messages = [
            'User_id.required' => 'User ID is required.',
            'User_id.exists' => 'User not found.',
            'User_full_name.required' => 'User full name is required.',
            'User_full_name.string' => 'User full name must be a string.',
            'User_full_name.max' => 'User full name must not exceed 255 characters.',
            'Course_id.required' => 'Course ID is required.',
            'Course_id.exists' => 'Course not found.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the owner
        $owner = new Owner();
        $owner->User_id = $request->User_id;
        $owner->User_full_name = $request->User_full_name;
        $owner->Course_id = $request->Course_id;
        $owner->save();

        return $owner;
    }

    // Read
    public function show($id)
    {
        $owner = Owner::find($id);
        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        return $owner;
    }

    public function ownerList()
    {
        return Owner::all();
    }

    // Update
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'User_full_name' => 'string|max:255',
            'Course_id' => 'exists:courses,id',
        ];

        // Custom error messages
        $messages = [
            'User_full_name.string' => 'User full name must be a string.',
            'User_full_name.max' => 'User full name must not exceed 255 characters.',
            'Course_id.exists' => 'Course not found.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the owner by ID
        $owner = Owner::find($id);

        // Check if the owner exists
        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        // Update owner attributes with request data
        $owner->User_full_name = $request->input('User_full_name', $owner->User_full_name);
        $owner->Course_id = $request->input('Course_id', $owner->Course_id);
        $owner->save();

        return $owner;
    }

    // Delete
    public function delete($id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        $owner->delete();

        return response()->json(['message' => 'Owner deleted successfully']);
    }
}
