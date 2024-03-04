<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use App\Models\Data;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class DataController extends Controller
{
    public function dashboard()
    {
        $data = Data::all();
        return view('dashboard', compact('data'));
    }

    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());

        $import = new DataImport();
        Excel::import($import, storage_path("app/{$filePath}"));

        $previewData = $import->getData();

        session(['uploadedFilePath' => $filePath]);

        return view('upload', compact('previewData'))->with('success', 'File uploaded successfully');
    }
    public function storeDynamicData(Request $request)
{
    try {
        // Validate the request data
        $request->validate([
            'dynamic_data' => 'required|array',
        ]);

        // Save dynamic data
        $dynamicData = $request->dynamic_data;

        // Assuming 'Data' is the model for the 'excel_data' table
        Data::create([
            'SID' => $dynamicData['SID'],
            'Name' => $dynamicData['Name'],
            'Address' => $dynamicData['Address'],
            'No' => $dynamicData['No'],
            'DOB' => $dynamicData['DOB'],
            'Status' => $dynamicData['Status'],
            // Add other columns as needed
        ]);

        // Optionally, you can return a response or redirect
        return response()->json(['message' => 'Dynamic Data saved successfully']);
    } catch (\Exception $e) {
        // Log the exception details
        Log::error('Error in storeDynamicData: ' . $e->getMessage());

        // Return an error response
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

    public function download()
    {
        $filePath = session('uploadedFilePath');

        return Storage::download($filePath, 'original_file.xlsx');
    }
}
