<?php

namespace App\Livewire;

use App\Models\AiStudyTip;
use App\Services\AIStudyTipService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class AiTipGenerator extends Component
{
    // Basic Info
    public $subject;
    public $daysUntilExam;
    
    // NEW: Enhanced Inputs
    public $academicLevel;
    public $understandingLevel;
    public $availableHoursPerDay;
    public $learningStyle;
    public $difficultTopics;
    public $specificGoals;
    public $additionalNotes;
    
    // State
    public $generatedPlan = '';
    public $isGenerating = false;
    public $recentPlans;
    public $selectedPlan = null; // New property for modal
    
    protected $rules = [
        'subject' => 'required|string|max:100',
        'daysUntilExam' => 'nullable|integer|min:1|max:365',
        'academicLevel' => 'required|string',
        'understandingLevel' => 'required|string',
        'availableHoursPerDay' => 'required|integer|min:1|max:12',
        'learningStyle' => 'required|string',
        'difficultTopics' => 'nullable|string|max:500',
        'specificGoals' => 'nullable|string|max:300',
        'additionalNotes' => 'nullable|string|max:300',
    ];
    
    protected $messages = [
        'subject.required' => 'Veuillez sélectionner une matière',
        'academicLevel.required' => 'Veuillez indiquer votre niveau d\'études',
        'understandingLevel.required' => 'Veuillez indiquer votre niveau de compréhension',
        'availableHoursPerDay.required' => 'Veuillez indiquer votre temps disponible',
        'learningStyle.required' => 'Veuillez sélectionner votre style d\'apprentissage',
    ];
    
    public function mount()
    {
        $this->loadRecentPlans();
    }
    
    public function loadRecentPlans()
    {
        $this->recentPlans = AiStudyTip::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
    
    public function generateEnhancedPlan()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();
        
        $this->isGenerating = true;
        $this->generatedPlan = '';
        
        try {
            $aiService = new AIStudyTipService();
            
            // Pass all the enhanced data
            $this->generatedPlan = $aiService->generateEnhancedStudyPlan(
                userId: Auth::id(), // Ensure int
                subject: $this->subject,
                daysUntilExam: $this->daysUntilExam,
                academicLevel: $this->academicLevel,
                understandingLevel: $this->understandingLevel,
                availableHoursPerDay: $this->availableHoursPerDay,
                learningStyle: $this->learningStyle,
                difficultTopics: $this->difficultTopics,
                specificGoals: $this->specificGoals,
                additionalNotes: $this->additionalNotes
            );
            
            session()->flash('message', 'Plan d\'étude généré avec succès! 🎉');
            $this->loadRecentPlans();
            
        } catch (\Throwable $e) {
            Log::error('AI Generation Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            session()->flash('error', 'Erreur lors de la génération. Veuillez réessayer.');
        }
        
        $this->isGenerating = false;
    }
    
    public function deletePlan($id)
    {
        AiStudyTip::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        
        session()->flash('message', 'Plan supprimé!');
        $this->loadRecentPlans();
    }
    
    public function showPlan($id)
    {
        $this->selectedPlan = AiStudyTip::find($id);
    }

    public function closeModal()
    {
        $this->selectedPlan = null;
    }

    public function exportPdf()
    {
        if (!$this->generatedPlan) return;

        $data = [
            'subject' => $this->subject,
            'plan' => $this->generatedPlan,
            'academicLevel' => $this->academicLevel,
            'learningStyle' => $this->learningStyle,
            'hours' => $this->availableHoursPerDay,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('livewire.ai-tip-generator-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'plan-' . Str::slug($this->subject) . '-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportHistoryPdf($id)
    {
        $plan = AiStudyTip::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Metadata extraction if available, otherwise defaults
        $metadata = json_decode($plan->metadata ?? '{}', true);

        $data = [
            'subject' => $plan->subject,
            'plan' => $plan->tip_content,
            'academicLevel' => $metadata['academic_level'] ?? 'N/A',
            'learningStyle' => $metadata['learning_style'] ?? 'N/A',
            'hours' => $metadata['available_hours'] ?? 'N/A',
            'generatedAt' => $plan->created_at,
        ];

        $pdf = Pdf::loadView('livewire.ai-tip-generator-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'plan-' . Str::slug($plan->subject) . '-' . $plan->created_at->format('YmdHis') . '.pdf');
    }

    public function resetForm()
    {
        $this->reset([
            'subject', 'daysUntilExam', 'academicLevel', 
            'understandingLevel', 'availableHoursPerDay', 
            'learningStyle', 'difficultTopics', 'specificGoals', 
            'additionalNotes', 'generatedPlan'
        ]);
    }
    
    public function render()
    {
        return view('livewire.ai-tip-generator');
    }
}