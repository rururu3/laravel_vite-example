<?php

use App\Events\ChatMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/chat', function (Request $request) {
    ChatMessageEvent::dispatch($request->message);
    return response()->json(['message' => 'Event has been sent!']);
});
