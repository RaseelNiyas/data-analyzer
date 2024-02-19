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
            'filters' => 'required|array',
        ]);

        foreach ($request->filters as $columnName => $filterType) {
            // Create a new Filter instance for each column
            $filter = new Filter;

            // Set values for each field from the form data
            $filter->filter_name = $columnName;
            $filter->filter_type = $filterType;

            // Save the filter to the database
            $filter->save();
        }

        // Redirect to the create page with a success message
        return redirect()->route('filter.create')->with('success', 'Filters created successfully');
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
