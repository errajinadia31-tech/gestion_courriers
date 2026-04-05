<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class CourrierPrintController extends Controller
{
    // فتح PDF فـ browser (Ctrl+P يخرج)
    public function print($id)
    {
        $courrier = Courrier::findOrFail($id);

        if (!$courrier->file || !Storage::disk('public')->exists($courrier->file)) {
            abort(404, 'PDF not found');
        }

        return response()->file(storage_path('app/public/' . $courrier->file));
    }

    // تحميل PDF مباشرة
    public function download($id)
    {
        $courrier = Courrier::findOrFail($id);

        if (!$courrier->file || !Storage::disk('public')->exists($courrier->file)) {
            abort(404, 'PDF not found');
        }

        return response()->download(
            storage_path('app/public/' . $courrier->file),
            'courrier_'.$courrier->reference.'.pdf'
        );
    }
}