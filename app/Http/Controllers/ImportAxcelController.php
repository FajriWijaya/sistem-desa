<?php

namespace App\Http\Controllers;

use App\Exports\TemplatePendudukExport;
use App\Http\Controllers\Controller;
use App\Imports\PendudukImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportAxcelController extends Controller
{
    

  public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        $import = new PendudukImport;
        Excel::import($import, $request->file('file'));

        if (count($import->errors) > 0) {
            return back()->with('errors_import', $import->errors);
        }

        return back()->with('created', 'Data berhasil diimport!');
    }

    // 📥 Download Template
    public function downloadTemplate()
    {
        return response()->download('import/template_penduduk.xlsx', 'tempalte.xlsx');
    }
}