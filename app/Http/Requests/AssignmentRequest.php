<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:100',
            'deadline' => 'required|date|after:yesterday',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string|max:1000',
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du devoir est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'subject.required' => 'La matière est obligatoire.',
            'deadline.required' => 'La date limite est obligatoire.',
            'deadline.after' => 'La date limite doit être dans le futur.',
            'priority.required' => 'La priorité est obligatoire.',
            'priority.in' => 'La priorité doit être: basse, moyenne ou haute.',
        ];
    }
}
