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
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'mark' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ];

        // Custom error messages
        $messages = [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'User not found.',
            'course_id.required' => 'Course ID is required.',
            'course_id.exists' => 'Course not found.',
            'mark.required' => 'Mark is required.',
            'mark.integer' => 'Mark must be an integer.',
            'mark.min' => 'Mark must be at least 1.',
            'mark.max' => 'Mark must not exceed 5.',
            'comment.string' => 'Comment must be a string.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the review
        $review = new Review();
        $review->user_id = $request->user_id;
        $review->course_id = $request->course_id;
        $review->mark = $request->mark;
        $review->comment = $request->comment;
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
            'mark' => 'integer|min:1|max:5',
            'comment' => 'nullable|string',
        ];

        // Custom error messages
        $messages = [
            'mark.integer' => 'Mark must be an integer.',
            'mark.min' => 'Mark must be at least 1.',
            'mark.max' => 'Mark must not exceed 5.',
            'comment.string' => 'Comment must be a string.',
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
        $review->mark = $request->input('mark', $review->mark);
        $review->comment = $request->input('comment', $review->comment);
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
