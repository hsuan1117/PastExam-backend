<?php

namespace App\Http\Controllers;

use App\Models\DownloadToken;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class DocumentDownloadController extends Controller
{
    public function download_request(Quiz $quiz)
    {
        $token = \Str::random(32);
        $quiz->downloadTokens()->create([
            'token' => $token,
            'expired_at' => now()->addMinutes(5),
            'user_id' => auth('sanctum')->id(),
        ]);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function download(Request $request)
    {
        $re = DownloadToken::whereToken($request->input('token'))->firstOrFail();
        if ($re->expired_at < now()) {
            abort(403);
        }

        $token = PersonalAccessToken::findToken($request->input('at'));
        $user = $token->tokenable;
        if ($user->id != $re->user_id) {
            abort(403);
        }

        $path = storage_path('app/' . $re->quiz->path);
        return response()->download($path, $re->quiz->filename);
    }
}
