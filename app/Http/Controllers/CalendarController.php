<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        $currentDate = Carbon::create($year, $month, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        
        // Get assignments for this month
        $assignments = Assignment::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereBetween('deadline', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
            ->get()
            ->groupBy(function($item) {
                return $item->deadline->format('Y-m-d');
            });
        
        // Generate calendar days
        $calendarStart = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);
        
        $weeks = [];
        $currentWeek = [];
        
        for ($date = $calendarStart->copy(); $date->lte($calendarEnd); $date->addDay()) {
            $currentWeek[] = [
                'date' => $date->copy(),
                'isCurrentMonth' => $date->month == $month,
                'isToday' => $date->isToday(),
                'assignments' => $assignments->get($date->format('Y-m-d'), collect())
            ];
            
            if ($date->dayOfWeek == Carbon::SUNDAY) {
                $weeks[] = $currentWeek;
                $currentWeek = [];
            }
        }
        
        if (!empty($currentWeek)) {
            $weeks[] = $currentWeek;
        }
        
        return view('calendar.index', compact('weeks', 'currentDate'));
    }
}
