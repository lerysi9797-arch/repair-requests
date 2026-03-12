<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function create()
    {
        return view('requests.create');
    }

    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'problem_text' => 'required|string',
        ]);

        Request::create([
            'client_name' => $validated['client_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'problem_text' => $validated['problem_text'],
            'status' => 'new',
            'assigned_to' => null,
        ]);

        return redirect()->back()->with('success', 'Заявка создана!');
    }
}
