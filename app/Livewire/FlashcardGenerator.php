<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FlashcardDeck;
use App\Models\Flashcard;
use App\Services\AiFlashcardService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class FlashcardGenerator extends Component
{
    public $topic = 'Général';
    public $sourceText = '';
    public $numCards = 5;
    
    public $currentDeck;
    public $isReviewing = false;
    public $reviewIndex = 0;
    public $isFlipped = false;
    public $deckComplete = false;

    public $isGenerating = false;
    public $history = [];
    public $selectedDeck = null;

    public function mount()
    {
        $this->loadHistory();
    }

    public function loadHistory()
    {
        $this->history = FlashcardDeck::where('user_id', Auth::id())
            ->withCount('cards')
            ->latest()
            ->take(6)
            ->get();
    }

    public function showDeck($id)
    {
        $this->selectedDeck = FlashcardDeck::with('cards')->find($id);
    }

    public function closeModal()
    {
        $this->selectedDeck = null;
    }

    public function exportPdf()
    {
        if (!$this->currentDeck) return;

        $data = [
            'topic' => $this->topic,
            'deck' => $this->currentDeck,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('livewire.flashcard-generator-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'flashcards-' . Str::slug($this->topic) . '-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportHistoryPdf($id)
    {
        $deck = FlashcardDeck::with('cards')->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = [
            'topic' => $deck->name,
            'deck' => $deck,
            'generatedAt' => $deck->created_at,
        ];

        $pdf = Pdf::loadView('livewire.flashcard-generator-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'flashcards-' . Str::slug($deck->name) . '-' . $deck->created_at->format('YmdHis') . '.pdf');
    }

    protected $rules = [
        'sourceText' => 'required|min:20',
        'topic' => 'required|string',
    ];

    public function generateCards()
    {
        $this->validate();

        $this->isGenerating = true;
        $this->deckComplete = false;

        try {
            $service = new AiFlashcardService();
            $this->currentDeck = $service->generateDeck(
                userId: Auth::id(),
                topic: $this->topic,
                content: $this->sourceText,
                count: $this->numCards
            );
            
            // Reload with cards
            $this->currentDeck->load('cards');
            
            // Start Review immediately on success
            $this->startReview();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }

        $this->isGenerating = false;
    }

    public function startReview()
    {
        $this->isReviewing = true;
        $this->reviewIndex = 0;
        $this->isFlipped = false;
        $this->deckComplete = false;
    }

    public function nextCard()
    {
        if ($this->reviewIndex < $this->currentDeck->cards->count() - 1) {
            $this->reviewIndex++;
            $this->isFlipped = false;
        } else {
            // Finish Review
            $this->deckComplete = true;
            $this->isReviewing = false;
        }
    }

    public function prevCard()
    {
        if ($this->reviewIndex > 0) {
            $this->reviewIndex--;
            $this->isFlipped = false;
        }
    }

    public function flip()
    {
        $this->isFlipped = !$this->isFlipped;
    }

    public function render()
    {
        return view('livewire.flashcard-generator')->layout('layouts.app');
    }
}
