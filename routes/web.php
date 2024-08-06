<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/invitations/accept/{token}', function ($token) {
    $invitation = App\Models\Invitation::where('token', $token)->first();
    if ($invitation) {
        $invitation->accepted = true;
        $invitation->responded = true;
        $invitation->save();
        return view('invite-accepted');
    }
    return 'Invitation not found';
})->name('invitations.accept');

Route::get('/invitations/decline/{token}', function ($token) {
    $invitation = App\Models\Invitation::where('token', $token)->first();
    if ($invitation) {
        $invitation->accepted = false;
        $invitation->responded = true;
        $invitation->save();
        return view('invite-declined');
    }
    return 'Invitation not found';
})->name('invitations.decline');
