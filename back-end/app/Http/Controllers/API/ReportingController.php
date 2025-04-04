<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_examens' => Exam::count(),
            'examens_termines' => Exam::where('statut', 'termine')->count(),
            'taux_reussite_global' => Exam::where('statut', 'termine')->avg('taux_reussite'),
            'candidats_inscrits' => DB::table('exam_candidat')->distinct('candidat_id')->count('candidat_id')
        ];

        $successRates = Exam::select([
                'type',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(taux_reussite) as taux_moyen'),
                DB::raw('SUM(nombre_presents) as total_presents')
            ])
            ->where('statut', 'termine')
            ->groupBy('type')
            ->get();

        $moniteursStats = User::whereHas('exams', fn($q) => $q->where('statut', 'termine'))
            ->withCount(['exams as exams_termines' => fn($q) => $q->where('statut', 'termine')])
            ->withAvg(['exams as taux_reussite_moyen' => fn($q) => $q->where('statut', 'termine')], 'taux_reussite')
            ->having('exams_termines', '>', 0)
            ->orderByDesc('taux_reussite_moyen')
            ->limit(10)
            ->get();

        return view('reporting.index', compact('stats', 'successRates', 'moniteursStats'));
    }

 
}