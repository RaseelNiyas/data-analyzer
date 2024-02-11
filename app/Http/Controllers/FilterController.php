<?php
// app/Http/Controllers/FilterController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;

class FilterController extends Controller
{
    public function create()
    {
        return view('filter-create');
    }

    public function store(Request $request)
    {
        // Validate and store the filter data in the database
        $validatedData = $request->validate([
            'filter_name' => 'required|string|max:255',
            'filter_type' => 'required|in:text,integer,list,date,boolean',
            // Add other validation rules as needed
        ]);

        // Create a new Filter model instance and store the data
        $filter = Filter::create([
            'filter_name' => $validatedData['filter_name'],
            'filter_type' => $validatedData['filter_type'],
            // Add other columns as needed
        ]);

        // Optionally, you can redirect to a success page or return a response
        return redirect()->route('filter.create')->with('success', 'Filter created successfully');
    }
}
