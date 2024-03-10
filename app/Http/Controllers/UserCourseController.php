<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Validator;

class UserCourseController extends Controller
{
    // Create
    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ];

        // Custom error messages
        $messages = [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'User not found.',
            'course_id.required' => 'Course ID is required.',
            'course_id.exists' => 'Course not found.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the owner
        $user_course = new UserCourse();
        $user_course ->user_id = $request->user_id;
        $user_course ->course_id = $request->course_id;
        $user_course ->save();

        return $user_course;
    }

    // Read
    public function show($id)
    {
        $user_courses  = UserCourse::find($id);
        if (!$user_courses ) {
            return response()->json(['message' => 'User courses not found'], 404);
        }

        return $user_courses ;
    }

    public function list()
    {
        return UserCourse::all();
    }

    // Update
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'course_id' => 'exists:courses,id',
        ];

        // Custom error messages
        $messages = [
            'course_id.exists' => 'Course not found.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the owner by ID
        $user_courses = UserCourse::find($id);

        // Check if the owner exists
        if (!$user_courses ) {
            return response()->json(['message' => 'User course not found'], 404);
        }

        // Update owner attributes with request data
        $user_courses->course_id = $request->course_id;
        $user_courses->save();

        return $user_courses;
    }

    // Delete
    public function delete($id)
    {
        $user_course = UserCourse::find($id);

        if (!$user_course) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        $user_course->delete();

        return response()->json(['message' => 'Owner deleted successfully']);
    }
}
