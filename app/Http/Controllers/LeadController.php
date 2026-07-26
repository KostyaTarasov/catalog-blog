<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LeadController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'message' => ['nullable', 'string', 'max:5000'],
            'consent' => ['accepted'],
        ]);

        Lead::create(Arr::only($data, ['name', 'phone', 'message']));

        return back()->with('lead-sent', true);
    }
}
