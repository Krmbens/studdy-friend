<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assignment;
use Barryvdh\DomPDF\Facade\Pdf;

class AssignmentManager extends Component
{
    public $assignments;
    public $title, $subject, $deadline, $priority = 'medium', $description;
    public $editingId = null;
    public $showForm = false;
    public $viewingAssignment = null;
    
    // Search and filters
    public $search = '';
    public $filterPriority = '';
    public $filterCompleted = '';
    public $filterSubject = '';

    public function updatingSearch()
    {
        // Si on utilise la pagination, on remettrait la page à 1 ici
    }

    public function rules()
    {
        return (new \App\Http\Requests\AssignmentRequest())->rules();
    }

    public function messages()
    {
        return (new \App\Http\Requests\AssignmentRequest())->messages();
    }
    
    public function mount()
    {
        if (request()->has('create')) {
            $this->showForm = true;
        }

        if (request()->has('filter')) {
            $filter = request('filter');
            if ($filter === 'progress') {
                $this->filterCompleted = '0'; // En cours
            } elseif ($filter === 'completed') {
                $this->filterCompleted = '1'; // Terminés
            }
        }

        if (request()->has('priority')) {
            $this->filterPriority = request('priority');
        }

        $this->loadAssignments();
    }
    
    public function loadAssignments()
    {
        $query = Assignment::where('user_id', \Illuminate\Support\Facades\Auth::id());
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('subject', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        if ($this->filterSubject) {
            $query->where('subject', $this->filterSubject);
        }
        
        if ($this->filterCompleted !== '') {
            $query->where('completed', $this->filterCompleted);
        }
        
        $this->assignments = $query->orderBy('deadline', 'asc')->get();
    }
    
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterPriority', 'filterCompleted', 'filterSubject'])) {
            $this->loadAssignments();
        }
    }
    
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->resetForm();
    }
    
    public function save()
    {
        $this->validate();
        
        sleep(1); // Simulation pour voir le loading
        
        $message = '';
        if ($this->editingId) {
            $assignment = Assignment::find($this->editingId);
            $assignment->update([
                'title' => $this->title,
                'subject' => $this->subject,
                'deadline' => $this->deadline,
                'priority' => $this->priority,
                'description' => $this->description,
            ]);
            $message = 'Devoir modifié avec succès!';
        } else {
            Assignment::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'title' => $this->title,
                'subject' => $this->subject,
                'deadline' => $this->deadline,
                'priority' => $this->priority,
                'description' => $this->description,
            ]);
            $message = 'Devoir ajouté avec succès!';
        }
        
        $this->dispatch('flash-message', message: $message, type: 'success');
        
        $this->resetForm();
        $this->loadAssignments();
        $this->showForm = false;
    }
    
    public function edit($id)
    {
        $assignment = Assignment::find($id);
        $this->editingId = $id;
        $this->title = $assignment->title;
        $this->subject = $assignment->subject;
        $this->deadline = $assignment->deadline->format('Y-m-d');
        $this->priority = $assignment->priority;
        $this->description = $assignment->description;
        $this->showForm = true;
    }
    
    public function delete($id)
    {
        Assignment::find($id)->delete();
        $this->dispatch('flash-message', message: 'Devoir supprimé!', type: 'info');
        $this->loadAssignments();
    }
    
    public function toggleComplete($id)
    {
        $assignment = Assignment::find($id);
        $assignment->update(['completed' => !$assignment->completed]);
        $this->loadAssignments();
        
        // Refresh viewing assignment if open
        if ($this->viewingAssignment && $this->viewingAssignment->id == $id) {
            $this->viewingAssignment = $assignment->fresh();
        }
    }

    public function viewDetails($id)
    {
        $this->viewingAssignment = Assignment::find($id);
    }

    public function closeDetails()
    {
        $this->viewingAssignment = null;
    }

    public function downloadPdf($id)
    {
        $assignment = Assignment::findOrFail($id);
        $pdf = Pdf::loadView('assignments.pdf', compact('assignment'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'devoir-' . $assignment->id . '.pdf');
    }
    
    public function resetForm()
    {
        $this->reset(['title', 'subject', 'deadline', 'priority', 'description', 'editingId']);
    }
    
    public function render()
    {
        return view('livewire.assignment-manager');
    }
}
