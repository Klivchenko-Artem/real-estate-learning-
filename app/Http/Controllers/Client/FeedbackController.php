<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => ['required', 'string', 'regex:/^\+7\d{10}$/'],
            'email'   => 'nullable|email|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        Feedback::create($request->only('name', 'phone', 'email', 'message'));

        return back()->with('success', 'Ваша заявка принята! Мы свяжемся с вами в ближайшее время.');
    }
}
