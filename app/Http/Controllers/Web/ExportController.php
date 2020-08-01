<?php

namespace App\Http\Controllers\Web;

use App\Exports\FromTableExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function descargar(Request $request)
    {
        $headings = $request->get('headings');
        $data = $request->get('data');
        return (new FromTableExport($headings, $data))->download('EXPORT.xlsx');
    }
}
