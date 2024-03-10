<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function create(Request $request)
{
    // Validation rules
    $rules = [
        'course_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
    ];

    // Custom error messages
    $messages = [
        'course_name.required' => 'Course name is required.',
        'price.required' => 'Price is required.',
        'price.numeric' => 'Price must be a number.',
        'price.min' => 'Price must be at least 0.',
        'description.required' => 'Description is required.',
    ];

    // Validate the request data
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // If validation passes, proceed to create the course
    $course = new Course();
    $course->course_name = $request->course_name; 
    $course->price = $request->price;
    $course->description = $request->description;
    $course->save();

    return $course;
}
    
    //read
    public function item($id)
    {
        $course =Course::find($id);
        return ($course);
    }

    public function CourseList(){
        return Course::all();
    }

    public function delete($id)
    {
        $course = Course::find($id);
    
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }
    
        $course->delete();
    
        return response()->json(['message' => 'Course deleted successfully']);
    }

    public function update(Request $request, $id)
    {
    // Validation rules
    $rules = [
        'course_name' => 'string|max:255',
        'price' => 'numeric|min:0',
        'description' => 'string',
    ];

    // Custom error messages
    $messages = [
        'course_name.string' => 'Course name must be a string.',
        'course_name.max' => 'Course name must not exceed 255 characters.',
        'price.numeric' => 'Price must be a number.',
        'price.min' => 'Price must be at least 0.',
        'description.string' => 'Description must be a string.',
    ];

    // Validate the request data
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Find the course by ID
    $course = Course::find($id);

    // Check if the course exists
    if (!$course) {
        return response()->json(['message' => 'Course not found'], 404);
    }

    // Update course attributes with request data
    $course->course_name = $request->course_name;
    $course->price = $request->price;
    $course->description = $request->description;
    $course->save();

    return $course;
    }
}
