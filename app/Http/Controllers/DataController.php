<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use App\Models\Data;
use Illuminate\Support\Facades\Storage;

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

    public function download()
    {
        $filePath = session('uploadedFilePath');

        return Storage::download($filePath, 'original_file.xlsx');
    }
}
