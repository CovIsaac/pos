<?php

namespace App\Http\Controllers;

use App\Models\PrintJob;

class PrintJobController extends Controller
{
    public function index()
    {
        return PrintJob::all();
    }

    public function done(PrintJob $printJob)
    {
        $printJob->delete();

        return response()->noContent();
    }
}
