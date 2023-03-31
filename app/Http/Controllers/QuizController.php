<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $quiz = Quiz::query();
        if ($request->has('course_year')) {
            $quiz = $quiz->where('course_year', $request->input('course_year'));
        }
        if ($request->has('course')) {
            $quiz = $quiz->where('course', $request->input('course'));
        }
        if ($request->has('type')) {
            $quiz = $quiz->where('type', $request->input('type'));
        }
        if ($request->has('year')) {
            $quiz = $quiz->where('year', $request->input('year'));
        }
        if ($request->has('teacher')) {
            $quiz = $quiz->where('teacher', $request->input('teacher'));
        }
        return $quiz->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->middleware('auth:sanctum');
        $validated = $request->validate([
            'teacher' => 'required|string',
            'course_year' => 'required|string',
            'course' => 'required|string',
            'type' => 'required|string',
            'year' => 'required|string',
            'file' => 'required|file',
            'tags' => 'required|array',
            'tags.*' => 'required|string',
        ]);

        $quiz = auth('sanctum')->user()->quiz()->create($validated);
        $quiz->filename = $request->file('file')->getClientOriginalName();
        $quiz->path = $request->file('file')->store('quizzes');
        $quiz->save();
        return $quiz;
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return $quiz;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'teacher' => 'nullable|string',
            'course_year' => 'nullable|string',
            'course' => 'nullable|string',
            'type' => 'nullable|string',
            'year' => 'nullable|string',
            'file' => 'nullable|file',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ]);

        if ($request->has('title')) {
            $quiz->title = $request->input('title');
        }
        if ($request->has('file')) {
            $quiz->filename = $request->file('file')->getClientOriginalName();
            $quiz->path = $request->file('file')->store('quizzes');
        }
        if ($request->has('tags')) {
            $quiz->tags = $request->input('tags');
        }
        $quiz->save();
        return $quiz;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
