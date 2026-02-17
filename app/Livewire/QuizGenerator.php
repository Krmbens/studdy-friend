<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use App\Services\AiQuizService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class QuizGenerator extends Component
{
    // Configuration
    public $subject = '';
    public $sourceText = ''; // New property for specific content
    public $count = 5;
    public $difficulty = 'Moyen';
    
    // Quiz State
    public $questions = [];
    public $userAnswers = [];
    public $showResults = false;
    public $score = 0;
    
    // UI State
    public $isGenerating = false;
    public $history = [];
    public $selectedQuiz = null; // New property for modal

    protected $rules = [
        'subject' => 'required|string',
        'sourceText' => 'nullable|string|min:20', // Optional but must be valid if provided
        'count' => 'required|integer|min:1|max:20',
        'difficulty' => 'required|string',
    ];

    public function mount()
    {
        $this->loadHistory();
    }

    public function loadHistory()
    {
        $this->history = Quiz::where('user_id', Auth::id())
            ->latest()
            ->take(5)
                ->get();
    }

    public function generate()
    {
        $this->validate();
        $this->isGenerating = true;
        $this->resetQuiz();

        try {
            $service = new AiQuizService();
            $topic = "Quiz " . $this->subject . " " . now()->format('d/m');
            
            $quiz = $service->generateQuiz(
                userId: Auth::id(),
                subject: $this->subject,
                topic: $topic,
                numQuestions: $this->count,
                difficulty: $this->difficulty,
                sourceContent: $this->sourceText // Pass source text
            );

            // Structure questions for easier handling in blade
            $this->questions = $quiz->questions->map(function($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question_text,
                    'options' => $q->options, // Already an array due to model cast
                    'correct_answer' => $q->correct_answer,
                    'explanation' => $q->explanation
                ];
            })->toArray();

            $this->loadHistory();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur Synthesis: ' . $e->getMessage());
        }

        $this->isGenerating = false;
    }

    public function selectAnswer($questionIndex, $optionIndex)
    {
        if (!$this->showResults) {
            $this->userAnswers[$questionIndex] = $optionIndex;
        }
    }

    public function submitQuiz()
    {
        if (count($this->userAnswers) < count($this->questions)) {
            session()->flash('error', 'Veuillez répondre à toutes les questions.');
            return;
        }

        $this->score = 0;
        foreach ($this->questions as $index => $q) {
            $options = $q['options'];
            $selectedText = $options[$this->userAnswers[$index]] ?? null;
            
            if ($selectedText === $q['correct_answer']) {
                $this->score += (100 / count($this->questions));
            }
        }
        
        $this->showResults = true;
    }

    public function resetQuiz()
    {
        $this->questions = [];
        $this->userAnswers = [];
        $this->showResults = false;
        $this->score = 0;
    }

    public function showQuiz($id)
    {
        $this->selectedQuiz = Quiz::with('questions')->find($id);
    }

    public function closeModal()
    {
        $this->selectedQuiz = null;
    }

    public function exportPdf()
    {
        if (empty($this->questions)) return;

        $data = [
            'subject' => $this->subject,
            'questions' => $this->questions,
            'score' => $this->showResults ? $this->score : null,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('livewire.quiz-generator-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'quiz-' . Str::slug($this->subject) . '-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportHistoryPdf($id)
    {
        $item = Quiz::with('questions')->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $questions = $item->questions->map(function($q) {
            return [
                'question' => $q->question_text,
                'options' => $q->options,
                'correct_answer' => $q->correct_answer,
                'explanation' => $q->explanation
            ];
        })->toArray();

        $data = [
            'subject' => $item->subject,
            'questions' => $questions,
            'score' => null,
            'generatedAt' => $item->created_at,
        ];

        $pdf = Pdf::loadView('livewire.quiz-generator-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'quiz-' . Str::slug($item->subject) . '-' . $item->created_at->format('YmdHis') . '.pdf');
    }

    public function render()
    {
        return view('livewire.quiz-generator')->layout('layouts.app');
    }
}
