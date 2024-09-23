<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generateApplicationPDF($id)
    {
        $application = Supplier::findOrFail($id);

        $data = [
            'name' => $application->name,
            'phone' => $application->phone,
            'current_locate' => $application->current_locate,
        ];

        $pdf = PDF::loadView('pdf.application', $data);

        return $pdf->stream('application-details.pdf');
    }
}
