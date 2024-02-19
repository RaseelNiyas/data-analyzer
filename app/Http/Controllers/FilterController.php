<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Filter;

class FilterController extends Controller
{
    public function create()
    {
        $columns = $this->getColumnsFromExcel();
        return view('upload', ['columns' => $columns]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'filter_name' => 'required|string|max:255',
            'filter_type' => 'required|string|max:255',
        ]);

        // Create a new Filter instance
        $filter = new Filter;

        // Set values for each field from the form data
        $filter->filter_name = $request->filter_name;
        $filter->filter_type = $request->filter_type;

        // Save the filter to the database
        $filter->save();

        // Redirect to the create page with a success message
        return redirect()->route('filter.create')->with('success', 'Filter created successfully');
    }


    private function getColumnsFromExcel()
    {
        // Implement logic to read columns from the .xlsx file
        // You can use the Laravel Excel package or any other library for reading Excel files
        // Example:
        $columns = ['column1', 'column2', 'column3']; // Replace with your logic to get columns dynamically
        return $columns;
    }
}
