<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    if (auth()->check()) {
        auth()->user()->update([
            'github_id' => $user->id,
            'github_token' => $user->token,
            'github_refresh_token' => $user->refreshToken,
            'github_username' => $user->nickname,
        ]);
    } else {
        $new = User::where('github_id', $user->id)->first();

        $full_name = $user->name;
        $name_parts = explode(' ', $full_name);
        $first_name = $name_parts[0];
        $last_name = $name_parts[count($name_parts) - 1];
        $middle_name = count($name_parts) > 2 ? $name_parts[1] : null;


        if (! $new) {
            $new = User::create([
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'username' => $user->nickname,
                'email' => $user->email,
                'github_id' => $user->id,
                'github_token' => $user->token,
                'github_refresh_token' => $user->refreshToken,
                'github_username' => $user->nickname,
                'email_verified_at' => now(),
            ]);
        }

        auth()->login($new);
    }
});
