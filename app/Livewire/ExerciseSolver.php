<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExerciseSolution;
use App\Services\AiExerciseSolverService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ExerciseSolver extends Component
{
    public $subject = 'Mathématiques';
    public $difficulty = 'Standard';
    public $solution = '';
    public $selectedSolution = null; // New property for modal
    public $isSolving = false;
    public $recentSolutions;
    public $problem = '';

    protected $rules = [
        'subject' => 'required|string|max:100',
        'problem' => 'required|string|min:10',
    ];

    public function mount()
    {
        $this->loadRecentSolutions();
    }

    public function loadRecentSolutions()
    {
        $this->recentSolutions = ExerciseSolution::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();
    }

    public function solve()
    {
        $this->validate();
        
        $this->isSolving = true;
        $this->solution = '';

        try {
            $service = new AiExerciseSolverService();
            
            // Map difficulty to detailLevel expected by service
            $detailLevel = match($this->difficulty) {
                'Expert' => 'expert',
                'Deep' => 'detailed',
                default => 'standard'
            };

            $result = $service->solveExercise(
                userId: Auth::id(),
                subject: $this->subject,
                problemStatement: $this->problem,
                detailLevel: $detailLevel
            );
            
            $this->solution = $result;

            session()->flash('message', 'Protocol completed successfully! 🎉');
            $this->loadRecentSolutions();

        } catch (\Exception $e) {
            session()->flash('error', 'Neural link failed. Please retry.');
        }

        $this->isSolving = false;
    }

    public function showSolution($id)
    {
        $this->selectedSolution = ExerciseSolution::find($id);
    }

    public function closeModal()
    {
        $this->selectedSolution = null;
    }

    public function exportPdf()
    {
        if (!$this->solution) {
            return;
        }

        $data = [
            'subject' => $this->subject,
            'problemStatement' => $this->problem,
            'solutionHtml' => Str::markdown($this->solution),
        ];

        $pdf = Pdf::loadView('livewire.exercise-solver-pdf', $data);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'solution-' . Str::slug($this->subject) . '-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportHistoryPdf($id)
    {
        $item = ExerciseSolution::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = [
            'subject' => $item->subject,
            'problemStatement' => $item->problem_statement,
            'solutionHtml' => Str::markdown($item->solution_content),
        ];

        $pdf = Pdf::loadView('livewire.exercise-solver-pdf', $data);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'solution-' . Str::slug($item->subject) . '-' . $item->created_at->format('YmdHis') . '.pdf');
    }

    public function render()
    {
        return view('livewire.exercise-solver')->layout('layouts.app');
    }
}
