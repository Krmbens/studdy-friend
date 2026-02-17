<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AiTipGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/assignments', function () {
        return view('assignments.index');
    })->name('assignments.index');
    Route::get('/study-sessions', function () {
        return view('study-sessions.index');
    })->name('study-sessions.index');
    Route::get('/ai-tips', function () {
        return view('ai-tips.index');
    })->name('ai-tips.index');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/export', [StatisticsController::class, 'exportPdf'])->name('statistics.export');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/pomodoro', \App\Livewire\PomodoroTimer::class)->name('pomodoro.index');
    Route::get('/exercise-solver', \App\Livewire\ExerciseSolver::class)->name('exercise-solver.index');
    Route::get('/quiz', \App\Livewire\QuizGenerator::class)->name('quiz.index');
    Route::get('/summarizer', \App\Livewire\DocumentSummarizer::class)->name('summarizer.index');
    Route::get('/flashcards', \App\Livewire\FlashcardGenerator::class)->name('flashcards.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
