<?php

namespace App\Http\Controllers\Article;

use App\Article;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;

class GeneratePDF extends ApiController
{
    public function pdf(Request $request) {

        $rules = [
            'start_date'        => 'required|date_format:Y-m-d',
            'end_date'          => 'required|date_format:Y-m-d|after:start_date',
        ];

        $this->validate($request, $rules);

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $articles = DB::table('articles')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->get();

        // TODO: Generar vista para el pdf
        $pdf = PDF::loadView('pdf.report-articles', compact('articles'));

        return response()->json(['data' => $articles]);

    }

}
