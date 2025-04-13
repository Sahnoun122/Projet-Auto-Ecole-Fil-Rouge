<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportingController extends Controller
{
    public function index()
    {
        return view('reporting.index');
    }

    public function getReportData(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $stats = [
            'total_examens' => Exam::whereBetween('date_exam', [$startDate, $endDate])->count(),
            'examens_termines' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                ->where('statut', 'termine')
                ->count(),
            'taux_reussite_global' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                ->where('statut', 'termine')
                ->avg('taux_reussite'),
            'candidats_inscrits' => DB::table('exam_candidat')
                ->whereHas('exam', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('date_exam', [$startDate, $endDate]);
                })
                ->distinct('candidat_id')
                ->count('candidat_id')
        ];

        $successRates = Exam::whereBetween('date_exam', [$startDate, $endDate])
            ->where('statut', 'termine')
            ->select([
                'type',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(taux_reussite) as taux_moyen'),
                DB::raw('SUM(nombre_presents) as total_presents')
            ])
            ->groupBy('type')
            ->get();

        $moniteursStats = User::whereHas('exams', function($q) use ($startDate, $endDate) {
                $q->whereBetween('date_exam', [$startDate, $endDate])
                  ->where('statut', 'termine');
            })
            ->withCount(['exams as exams_termines' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('date_exam', [$startDate, $endDate])
                  ->where('statut', 'termine');
            }])
            ->withAvg(['exams as taux_reussite_moyen' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('date_exam', [$startDate, $endDate])
                  ->where('statut', 'termine');
            }], 'taux_reussite')
            ->having('exams_termines', '>', 0)
            ->orderByDesc('taux_reussite_moyen')
            ->limit(10)
            ->get();

        $exams = Exam::whereBetween('date_exam', [$startDate, $endDate])
            ->orderBy('date_exam', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'stats' => $stats,
            'successRates' => $successRates,
            'moniteursStats' => $moniteursStats,
            'exams' => $exams
        ]);
    }

    public function generatePdfReport(Request $request)
    {
        $request->validate([
            'periode' => 'required|in:7,30,90,365,custom',
            'date_debut' => 'required_if:periode,custom|date',
            'date_fin' => 'required_if:periode,custom|date|after_or_equal:date_debut'
        ]);

        if ($request->periode === 'custom') {
            $startDate = $request->date_debut;
            $endDate = $request->date_fin;
        } else {
            $days = $request->periode;
            $endDate = now()->format('Y-m-d');
            $startDate = now()->subDays($days)->format('Y-m-d');
        }

        $data = $this->getPdfReportData($startDate, $endDate);

        $pdf = PDF::loadView('reporting.pdf-template', $data);
        return $pdf->download('rapport-examens-'.now()->format('Y-m-d').'.pdf');
    }

    private function getPdfReportData($startDate, $endDate)
    {
        $stats = [
            'total_examens' => Exam::whereBetween('date_exam', [$startDate, $endDate])->count(),
            'examens_termines' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                ->where('statut', 'termine')
                ->count(),
            'taux_reussite_global' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                ->where('statut', 'termine')
                ->avg('taux_reussite'),
            'candidats_inscrits' => DB::table('exam_candidat')
                ->whereHas('exam', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('date_exam', [$startDate, $endDate]);
                })
                ->distinct('candidat_id')
                ->count('candidat_id')
        ];

        $successRates = Exam::whereBetween('date_exam', [$startDate, $endDate])
            ->where('statut', 'termine')
            ->select([
                'type',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(taux_reussite) as taux_moyen'),
                DB::raw('SUM(nombre_presents) as total_presents')
            ])
            ->groupBy('type')
            ->get();

        $moniteursStats = User::whereHas('exams', function($q) use ($startDate, $endDate) {
                $q->whereBetween('date_exam', [$startDate, $endDate])
                  ->where('statut', 'termine');
            })
            ->withCount(['exams as exams_termines' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('date_exam', [$startDate, $endDate])
                  ->where('statut', 'termine');
            }])
            ->withAvg(['exams as taux_reussite_moyen' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('date_exam', [$startDate, $endDate])
                  ->where('statut', 'termine');
            }], 'taux_reussite')
            ->having('exams_termines', '>', 0)
            ->orderByDesc('taux_reussite_moyen')
            ->limit(10)
            ->get();

        $exams = Exam::whereBetween('date_exam', [$startDate, $endDate])
            ->orderBy('date_exam', 'desc')
            ->limit(50)
            ->get();

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'stats' => $stats,
            'successRates' => $successRates,
            'moniteursStats' => $moniteursStats,
            'exams' => $exams
        ];
    }
}