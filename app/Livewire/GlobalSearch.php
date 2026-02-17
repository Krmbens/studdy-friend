<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assignment;
use App\Models\AiStudyTip;
use App\Models\Quiz;
use App\Models\StudySession;
use Illuminate\Support\Facades\Auth;

class GlobalSearch extends Component
{
    public $search = '';
    public $results = [];
    public $showDropdown = false;

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            $this->showDropdown = false;
            return;
        }

        $userId = Auth::id();
        $query = '%' . $this->search . '%';

        // Assignments
        $assignments = Assignment::where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', $query)
                  ->orWhere('subject', 'like', $query);
            })
            ->limit(3)
            ->get()
            ->map(fn($item) => [
                'type' => 'Assignment',
                'title' => $item->title,
                'subtitle' => $item->subject,
                'url' => route('assignments.index'),
                'icon' => 'assignment'
            ]);

        // Tips
        $tips = AiStudyTip::where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('subject', 'like', $query)
                  ->orWhere('tip_content', 'like', $query);
            })
            ->limit(3)
            ->get()
            ->map(fn($item) => [
                'type' => 'AI Tip',
                'title' => $item->subject,
                'subtitle' => 'Intelligence Insight',
                'url' => route('ai-tips.index'),
                'icon' => 'brain'
            ]);

        // Quizzes
        $quizzes = Quiz::where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', $query)
                  ->orWhere('subject', 'like', $query);
            })
            ->limit(3)
            ->get()
            ->map(fn($item) => [
                'type' => 'Quiz',
                'title' => $item->title ?: $item->subject,
                'subtitle' => 'Assessment',
                'url' => route('quiz.index'),
                'icon' => 'quiz'
            ]);

        $this->results = collect()
            ->concat($assignments)
            ->concat($tips)
            ->concat($quizzes)
            ->toArray();

        $this->showDropdown = !empty($this->results);
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
