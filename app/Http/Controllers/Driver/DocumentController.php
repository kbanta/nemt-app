<?php
namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverDocument;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'file'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('file')->store('driver-documents', 'public');
        $driver = auth()->user()->driver;

        DriverDocument::create([
            'driver_id'     => $driver->id,
            'document_type' => $request->document_type,
            'file_path'     => $path,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }
}