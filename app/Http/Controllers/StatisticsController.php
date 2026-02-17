<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\StudySession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StatisticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Total statistics
        $totalAssignments = Assignment::where('user_id', $userId)->count();
        $completedAssignments = Assignment::where('user_id', $userId)
            ->where('completed', true)
            ->count();
        $completionRate = $totalAssignments > 0 
            ? round(($completedAssignments / $totalAssignments) * 100) 
            : 0;
        
        // Study time by day (last 7 days)
        $studyByDay = StudySession::where('user_id', $userId)
            ->where('session_date', '>=', now()->subDays(7))
            ->selectRaw('session_date, SUM(duration_minutes) as total')
            ->groupBy('session_date')
            ->orderBy('session_date', 'asc')
            ->get();
        
        // Assignments by priority
        $assignmentsByPriority = Assignment::where('user_id', $userId)
            ->selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->get();
        
        // Most studied subjects
        $topSubjects = StudySession::where('user_id', $userId)
            ->selectRaw('subject, SUM(duration_minutes) as total, COUNT(*) as sessions')
            ->groupBy('subject')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        return view('statistics.index', compact(
            'totalAssignments',
            'completedAssignments',
            'completionRate',
            'studyByDay',
            'assignmentsByPriority',
            'topSubjects'
        ));
    }

    public function exportPdf()
    {
        $userId = Auth::id();
        
        $data = [
            'user' => Auth::user(),
            'totalAssignments' => Assignment::where('user_id', $userId)->count(),
            'completedAssignments' => Assignment::where('user_id', $userId)->where('completed', true)->count(),
            'totalStudyTime' => StudySession::where('user_id', $userId)->sum('duration_minutes'),
            'topSubjects' => StudySession::where('user_id', $userId)
                ->selectRaw('subject, SUM(duration_minutes) as total')
                ->groupBy('subject')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'generatedAt' => now(),
        ];
        
        $pdf = Pdf::loadView('statistics.pdf', $data);
        
        return $pdf->download('statistiques-' . now()->format('Y-m-d') . '.pdf');
    }
}
