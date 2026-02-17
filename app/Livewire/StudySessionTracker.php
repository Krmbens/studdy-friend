<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\StudySession;
use Carbon\Carbon;

class StudySessionTracker extends Component
{
    public $sessions;
    public $subject;
    public $durationMinutes;
    public $sessionDate;
    public $notes;
    public $showForm = false;
    
    // Filter properties
    public $filterSubject = '';
    public $filterPeriod = 'all';
    
    // Viewing session
    public $viewingSession = null;
    
    // Timer properties
    public $isTimerRunning = false;
    public $timerMinutes = 0;
    public $currentSubject = '';
    
    protected $rules = [
        'subject' => 'required|string|max:100',
        'durationMinutes' => 'required|integer|min:1|max:600',
        'sessionDate' => 'required|date',
        'notes' => 'nullable|string',
    ];
    
    public function mount()
    {
        $this->sessionDate = now()->format('Y-m-d');
        if (request()->has('create')) {
            $this->showForm = true;
        }
        $this->loadSessions();
    }
    
    public function loadSessions()
    {
        $query = StudySession::where('user_id', \Illuminate\Support\Facades\Auth::id());
        
        // Apply subject filter
        if ($this->filterSubject) {
            $query->where('subject', $this->filterSubject);
        }
        
        // Apply period filter
        if ($this->filterPeriod === 'today') {
            $query->whereDate('session_date', now()->format('Y-m-d'));
        } elseif ($this->filterPeriod === 'week') {
            $query->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->filterPeriod === 'month') {
            $query->whereBetween('session_date', [now()->startOfMonth(), now()->endOfMonth()]);
        }
        
        $this->sessions = $query
            ->orderBy('session_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }
    
    public function save()
    {
        $this->validate();
        
        StudySession::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'subject' => $this->subject,
            'duration_minutes' => $this->durationMinutes,
            'session_date' => $this->sessionDate,
            'notes' => $this->notes,
        ]);
        
        $this->dispatch('flash-message', message: 'Session d\'étude enregistrée!', type: 'success');
        $this->resetForm();
        $this->loadSessions();
        $this->showForm = false;
    }
    
    public function delete($id)
    {
        StudySession::find($id)->delete();
        $this->dispatch('flash-message', message: 'Session supprimée!', type: 'info');
        $this->loadSessions();
    }
    
    public function resetForm()
    {
        $this->reset(['subject', 'durationMinutes', 'notes']);
        $this->sessionDate = now()->format('Y-m-d');
    }
    
    // Statistics
    public function getTotalStudyTimeThisWeek()
    {
        return StudySession::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('duration_minutes');
    }
    
    public function getTotalStudyTimeToday()
    {
        return StudySession::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('session_date', now()->format('Y-m-d'))
            ->sum('duration_minutes');
    }
    
    public function getTotalHours()
    {
        $query = StudySession::where('user_id', \Illuminate\Support\Facades\Auth::id());
        
        if ($this->filterSubject) {
            $query->where('subject', $this->filterSubject);
        }
        
        if ($this->filterPeriod === 'today') {
            $query->whereDate('session_date', now()->format('Y-m-d'));
        } elseif ($this->filterPeriod === 'week') {
            $query->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->filterPeriod === 'month') {
            $query->whereBetween('session_date', [now()->startOfMonth(), now()->endOfMonth()]);
        }
        
        return $query->sum('duration_minutes');
    }
    
    public function getDailyAverage()
    {
        $query = StudySession::where('user_id', \Illuminate\Support\Facades\Auth::id());
        
        if ($this->filterSubject) {
            $query->where('subject', $this->filterSubject);
        }
        
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        
        if ($this->filterPeriod === 'today') {
            return $this->getTotalHours();
        } elseif ($this->filterPeriod === 'week') {
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
        } elseif ($this->filterPeriod === 'month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } else {
            // For 'all', use last 30 days
            $startDate = now()->subDays(30);
            $endDate = now();
        }
        
        $query->whereBetween('session_date', [$startDate, $endDate]);
        $total = $query->sum('duration_minutes');
        $days = max(1, $startDate->diffInDays($endDate) + 1);
        
        return round($total / $days, 1);
    }
    
    public function viewSession($id)
    {
        $this->viewingSession = StudySession::find($id);
    }
    
    public function closeModal()
    {
        $this->viewingSession = null;
    }
    
    public function exportPdf($id)
    {
        $session = StudySession::findOrFail($id);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('study-sessions.pdf', [
            'session' => $session,
        ]);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'session-' . $session->id . '.pdf');
    }
    
    public function render()
    {
        return view('livewire.study-session-tracker', [
            'totalThisWeek' => $this->getTotalStudyTimeThisWeek(),
            'totalToday' => $this->getTotalStudyTimeToday(),
            'totalHours' => $this->getTotalHours(),
            'dailyAverage' => $this->getDailyAverage(),
        ]);
    }
}
