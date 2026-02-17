<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\StudySession;
use App\Models\AiStudyTip;
use App\Models\Quiz;
use App\Models\DocumentSummary;
use App\Models\ExerciseSolution;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        $upcomingAssignments = Assignment::with('user')
            ->where('user_id', $userId)
            ->where('completed', false)
            ->where('deadline', '>=', now())
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();
        
        $overdueAssignments = Assignment::where('user_id', $userId)
            ->where('completed', false)
            ->where('deadline', '<', now())
            ->count();
        
        $completedThisWeek = Assignment::where('user_id', $userId)
            ->where('completed', true)
            ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        
        $studyTimeThisWeek = StudySession::where('user_id', $userId)
            ->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('duration_minutes');

        $studyBySubject = StudySession::where('user_id', $userId)
            ->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('subject, SUM(duration_minutes) as total')
            ->groupBy('subject')
            ->orderByDesc('total')
            ->get();

        $focusSubject = $studyBySubject->first() ? $studyBySubject->first()->subject : 'N/A';

        // Calculate Current Streak
        $currentStreak = 0;
        $checkDate = now()->startOfDay();
        while (true) {
            $hasSession = StudySession::where('user_id', $userId)
                ->whereDate('session_date', $checkDate)
                ->exists();
            if ($hasSession) {
                $currentStreak++;
                $checkDate->subDay();
            } else {
                // If no session today, check if there was one yesterday to maintain a streak
                if ($currentStreak === 0) {
                    $checkDate->subDay();
                    $hasSessionYesterday = StudySession::where('user_id', $userId)
                        ->whereDate('session_date', $checkDate)
                        ->exists();
                    if (!$hasSessionYesterday) break;
                    // If yesterday had a session, we continue from there but don't count today yet
                } else {
                    break;
                }
            }
            if ($currentStreak > 365) break; 
        }

        // New Daily Study Time for Chart (Last 7 Days)
        $dailyStudyTime = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('D');
            $dailyStudyTime[] = StudySession::where('user_id', $userId)
                ->whereDate('session_date', $date)
                ->sum('duration_minutes');
        }

        // --- Neural Intelligence Feed ---
        $recentTips = AiStudyTip::where('user_id', $userId)->latest()->limit(2)->get();
        $recentQuizzes = Quiz::where('user_id', $userId)->with('questions')->latest()->limit(2)->get();
        $recentSummaries = DocumentSummary::where('user_id', $userId)->latest()->limit(2)->get();
        $recentSolutions = ExerciseSolution::where('user_id', $userId)->latest()->limit(2)->get();

        // Combined Intelligence Feed (sorted by date)
        $intelligenceFeed = collect()
            ->concat($recentTips->map(fn($item) => ['type' => 'tip', 'data' => $item, 'date' => $item->created_at]))
            ->concat($recentQuizzes->map(fn($item) => ['type' => 'quiz', 'data' => $item, 'date' => $item->created_at]))
            ->concat($recentSummaries->map(fn($item) => ['type' => 'summary', 'data' => $item, 'date' => $item->created_at]))
            ->concat($recentSolutions->map(fn($item) => ['type' => 'solution', 'data' => $item, 'date' => $item->created_at]))
            ->sortByDesc('date')
            ->take(4);
        
        // Extra stats for Dashboard
        $totalAssignmentsCount = Assignment::where('user_id', $userId)->count();
        $inProgressAssignmentsCount = Assignment::where('user_id', $userId)->where('completed', false)->count();
        $completedAssignmentsCount = Assignment::where('user_id', $userId)->where('completed', true)->count();
        
        $sessionsThisWeekCount = StudySession::where('user_id', $userId)
            ->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return view('dashboard', compact(
            'upcomingAssignments', 
            'completedThisWeek',
            'studyTimeThisWeek',
            'studyBySubject',
            'dailyStudyTime',
            'labels',
            'currentStreak',
            'focusSubject',
            'intelligenceFeed',
            'totalAssignmentsCount',
            'inProgressAssignmentsCount',
            'completedAssignmentsCount',
            'sessionsThisWeekCount'
        ));
    }
}
