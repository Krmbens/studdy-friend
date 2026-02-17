<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StudySession;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PomodoroTimer extends Component
{
    public $subject = 'General Study';
    public $notes = '';
    
    // Stats
    public $todaySessionsCount = 0;
    public $todayFocusMinutes = 0;
    public $streakValues = 0;

    public function mount()
    {
        $this->refreshStats();
    }

    public function refreshStats()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $this->todaySessionsCount = StudySession::where('user_id', $user->id)
            ->whereDate('session_date', $today)
            ->count();
            
        $this->todayFocusMinutes = StudySession::where('user_id', $user->id)
            ->whereDate('session_date', $today)
            ->sum('duration_minutes');

        // Simple streak calculation (consecutive days with at least one session)
        $this->streakValues = $this->calculateStreak($user->id);
    }
    
    private function calculateStreak($userId)
    {
        $streak = 0;
        $date = Carbon::today();
        
        while (true) {
            $hasSession = StudySession::where('user_id', $userId)
                ->whereDate('session_date', $date)
                ->exists();
                
            if ($hasSession) {
                $streak++;
                $date->subDay();
            } else {
                // If checking today and no session yet, don't break streak from yesterday
                if ($date->isToday() && $streak == 0) {
                    $date->subDay();
                    continue;
                }
                break;
            }
        }
        
        return $streak;
    }

    public function saveSession($durationSeconds, $type = 'pomodoro')
    {
        $minutes = round($durationSeconds / 60);
        
        if ($minutes < 1) return; // Don't save very short sessions

        StudySession::create([
            'user_id' => Auth::id(),
            'subject' => $this->subject ?: 'Pomodoro Session',
            'duration_minutes' => $minutes,
            'session_date' => Carbon::now(),
            'notes' => $this->notes . ($type === 'pomodoro' ? ' (Completed via Pomodoro Timer)' : ''),
        ]);

        $this->refreshStats();
        $this->dispatch('session-saved');
    }

    public function render()
    {
        return view('livewire.pomodoro-timer')->layout('layouts.app');
    }
}
