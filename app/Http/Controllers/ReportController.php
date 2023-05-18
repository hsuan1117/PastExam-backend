<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->report;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        if($quiz->reports()->where('user_id', auth()->user()->id)->count() > 0)
            return response()->json(['error' => '你已經舉報過這個考卷了！'], 403);
        $request->validate([
            'reason' => 'required|string',
        ]);
        return auth()->user()->report()->create([
            'quiz_id' => $quiz->id,
            'reason' => $request->input('reason'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        if (auth()->user()->id == $report->user_id)
            return $report;
        else
            return response()->json(['error' => 'Unauthorized'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
