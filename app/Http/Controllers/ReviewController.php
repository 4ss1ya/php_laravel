<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // Create
    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'User_id' => 'required|exists:users,id',
            'Course_id' => 'required|exists:courses,id',
            'Mark' => 'required|integer|min:1|max:5',
            'Comment' => 'nullable|string',
        ];

        // Custom error messages
        $messages = [
            'User_id.required' => 'User ID is required.',
            'User_id.exists' => 'User not found.',
            'Course_id.required' => 'Course ID is required.',
            'Course_id.exists' => 'Course not found.',
            'Mark.required' => 'Mark is required.',
            'Mark.integer' => 'Mark must be an integer.',
            'Mark.min' => 'Mark must be at least 1.',
            'Mark.max' => 'Mark must not exceed 5.',
            'Comment.string' => 'Comment must be a string.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the review
        $review = new Review();
        $review->User_id = $request->User_id;
        $review->Course_id = $request->Course_id;
        $review->Mark = $request->Mark;
        $review->Comment = $request->Comment;
        $review->save();

        return $review;
    }

    // Read
    public function show($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return $review;
    }

    public function reviewList()
    {
        return Review::all();
    }

    // Update
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'Mark' => 'integer|min:1|max:5',
            'Comment' => 'nullable|string',
        ];

        // Custom error messages
        $messages = [
            'Mark.integer' => 'Mark must be an integer.',
            'Mark.min' => 'Mark must be at least 1.',
            'Mark.max' => 'Mark must not exceed 5.',
            'Comment.string' => 'Comment must be a string.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the review by ID
        $review = Review::find($id);

        // Check if the review exists
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        // Update review attributes with request data
        $review->Mark = $request->input('Mark', $review->Mark);
        $review->Comment = $request->input('Comment', $review->Comment);
        $review->save();

        return $review;
    }

    // Delete
    public function delete($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
