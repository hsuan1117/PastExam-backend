<?php

namespace App\Http\Controllers;

use App\Models\User;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function google(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->addScope("email");

        try {
            $payload = $client->verifyIdToken($validated['token']);
            if(!$payload) throw new \Exception('Invalid token');
            $user = User::firstOrCreate([
                'email' => $payload['email'],
            ], [
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => Hash::make($payload['sub']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Google 登入失敗' . $e->getMessage(),
            ], 401);
        }
    }
}
