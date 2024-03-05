<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use App\Models\Data;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



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
    try {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());

        $import = new DataImport();
        Excel::import($import, storage_path("app/{$filePath}"));

        $data = $import->getData();

        if (count($data) < 2) {
            // No data or only header row found
            return view('upload')->with('error', 'No valid data found in the Excel file.');
        }

        $fieldList = $data[0]->toArray(); // First row as column names
        $rows = array_slice($data->toArray(), 1); // Exclude the header row

        // Use a database transaction
        DB::beginTransaction();

        try {
            // Drop existing 'data' table if it exists
            Schema::dropIfExists('data');

            // Create a new 'data' table with the provided fields
            Schema::create('data', function ($table) use ($fieldList) {
                $table->increments('id')->unique();

                foreach ($fieldList as $fieldName) {
                    $table->text($fieldName);
                }
            });

            // Disable mass assignment protection for 'Data' model
            Data::unguard();

            // Insert rows into the 'data' table
            foreach ($rows as $row) {
                // Assuming 'Data' is the model for the 'data' table
                Data::create(array_combine($fieldList, $row));
            }

            // Re-enable mass assignment protection
            Data::reguard();

            // Commit the transaction
            DB::commit();

            // Set the uploadedFilePath in the session
            session(['uploadedFilePath' => $filePath]);

            // Return the preview data for display
            return view('upload', compact('fieldList', 'rows'))->with('success', 'File uploaded successfully');
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();

            // Log the exception details
            Log::error('Error in upload: ' . $e->getMessage());

            // Return an error response
            return view('upload')->with('error', 'An error occurred during the upload process.');
        }
    } catch (\Exception $e) {
        // Log the exception details
        Log::error('Error in upload: ' . $e->getMessage());

        // Return an error response
        return view('upload')->with('error', 'An error occurred during the upload process.');
    }
}




    public function download()
    {
        $filePath = session('uploadedFilePath');

        return Storage::download($filePath, 'original_file.xlsx');
    }
}
