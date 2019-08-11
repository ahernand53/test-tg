<?php

namespace App\Http\Controllers\Article;

use App\Article;
use App\Http\Controllers\ApiController;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

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
        $articles = Article::with('category')
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();

        $pdf = PDF::loadView('reports', ['articles' => $articles]);

        return $pdf->download('reportes.pdf');

    }

}
