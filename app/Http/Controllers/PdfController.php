<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function __invoke(Code $order)
    {
        // ini_set('max_execution_time', 300);
        return Pdf::loadView('pdf', ['record' => $order])
            ->download('dawd.pdf');
    }
}
