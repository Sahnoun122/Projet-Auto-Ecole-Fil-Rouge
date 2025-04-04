<?php

namespace App\Http\Controllers\API;

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
            $endDate = now();
            $startDate = now()->subDays($days);
        }

        $data = $this->getReportData($startDate, $endDate);

        $pdf = PDF::loadView('reporting.pdf-template', $data);
        return $pdf->download('rapport-examens-'.now()->format('Y-m-d').'.pdf');
    }

    private function getReportData($startDate, $endDate)
    {
        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'stats' => [
                'total_examens' => Exam::whereBetween('date_exam', [$startDate, $endDate])->count(),
                'examens_termines' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                    ->where('statut', 'termine')
                    ->count(),
                'taux_reussite_global' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                    ->where('statut', 'termine')
                    ->avg('taux_reussite')
            ],
            'successRates' => Exam::whereBetween('date_exam', [$startDate, $endDate])
                ->where('statut', 'termine')
                ->select([
                    'type',
                    DB::raw('COUNT(*) as total'),
                    DB::raw('AVG(taux_reussite) as taux_moyen')
                ])
                ->groupBy('type')
                ->get(),
            'moniteursStats' => User::whereHas('exams', fn($q) => $q->whereBetween('date_exam', [$startDate, $endDate])->where('statut', 'termine'))
                ->withCount(['exams as exams_termines' => fn($q) => $q->whereBetween('date_exam', [$startDate, $endDate])->where('statut', 'termine')])
                ->withAvg(['exams as taux_reussite_moyen' => fn($q) => $q->whereBetween('date_exam', [$startDate, $endDate])->where('statut', 'termine')], 'taux_reussite')
                ->having('exams_termines', '>', 0)
                ->orderByDesc('taux_reussite_moyen')
                ->limit(10)
                ->get()
        ];
    }
}