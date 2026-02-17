<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\AiSummaryService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class DocumentSummarizer extends Component
{
    use WithFileUploads;

    public $textInput = '';
    public $fileInput; // For future file upload support
    public $style = 'key_points';
    public $summary = '';
    public $isGenerating = false;
    public $history = [];
    public $selectedSummary = null;

    public function mount()
    {
        $this->loadHistory();
    }

    public function loadHistory()
    {
        $this->history = \App\Models\DocumentSummary::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();
    }

    public function showSummary($id)
    {
        $this->selectedSummary = \App\Models\DocumentSummary::find($id);
    }

    public function closeModal()
    {
        $this->selectedSummary = null;
    }

    public function exportPdf()
    {
        if (!$this->summary) return;

        $data = [
            'summary' => $this->summary,
            'style' => $this->style,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('livewire.document-summarizer-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'resume-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportHistoryPdf($id)
    {
        $item = \App\Models\DocumentSummary::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = [
            'summary' => $item->summary_content,
            'style' => 'Archive',
            'generatedAt' => $item->created_at,
        ];

        $pdf = Pdf::loadView('livewire.document-summarizer-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'resume-' . $item->created_at->format('YmdHis') . '.pdf');
    }

    public function summarize()
    {
        $this->validate([
            'textInput' => 'required|min:50',
        ]);

        $this->isGenerating = true;

        try {
            $service = new AiSummaryService();
            $this->summary = $service->generateSummary(
                userId: Auth::id(),
                content: $this->textInput,
                style: $this->style
            );
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }

        $this->isGenerating = false;
    }

    public function render()
    {
        return view('livewire.document-summarizer')->layout('layouts.app');
    }
}
