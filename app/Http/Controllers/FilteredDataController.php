<?php

// app/Http/Controllers/FilteredDataController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilteredData;

class FilteredDataController extends Controller
{
    public function index()
    {
        $filteredData = FilteredData::all();

        return view('filtered-data', compact('filteredData'));
    }

    public function filterByType($type)
    {
        // Example: Filter data by type
        $filteredData = FilteredData::where('type', $type)->get();

        return view('filtered-data', compact('filteredData'));
    }

    // Add other methods as needed
}
