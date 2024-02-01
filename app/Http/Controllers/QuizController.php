<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    // Create
    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'User_id' => 'required|exists:users,id',
            'Course_id' => 'required|exists:courses,id',
            'Question' => 'required|string|max:255',
            'Answer' => 'required|string',
        ];

        // Custom error messages
        $messages = [
            'User_id.required' => 'User ID is required.',
            'User_id.exists' => 'User not found.',
            'Course_id.required' => 'Course ID is required.',
            'Course_id.exists' => 'Course not found.',
            'Question.required' => 'Question is required.',
            'Question.string' => 'Question must be a string.',
            'Question.max' => 'Question must not exceed 255 characters.',
            'Answer.required' => 'Answer is required.',
            'Answer.string' => 'Answer must be a string.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If validation passes, proceed to create the quiz
        $quiz = new Quiz();
        $quiz->User_id = $request->User_id;
        $quiz->Course_id = $request->Course_id;
        $quiz->Question = $request->Question;
        $quiz->Answer = $request->Answer;
        $quiz->save();

        return $quiz;
    }

    // Read
    public function show($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        return $quiz;
    }

    public function quizList()
    {
        return Quiz::all();
    }

    // Update
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'Question' => 'string|max:255',
            'Answer' => 'string',
        ];

        // Custom error messages
        $messages = [
            'Question.string' => 'Question must be a string.',
            'Question.max' => 'Question must not exceed 255 characters.',
            'Answer.string' => 'Answer must be a string.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the quiz by ID
        $quiz = Quiz::find($id);

        // Check if the quiz exists
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        // Update quiz attributes with request data
        $quiz->Question = $request->input('Question', $quiz->Question);
        $quiz->Answer = $request->input('Answer', $quiz->Answer);
        $quiz->save();

        return $quiz;
    }

    // Delete
    public function delete($id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted successfully']);
    }
}