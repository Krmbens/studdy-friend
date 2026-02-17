<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Assignment;
use App\Models\User;
use App\Notifications\DeadlineReminderNotification;
use Carbon\Carbon;

class SendDeadlineReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Envoie des rappels pour les devoirs à venir';

    public function handle()
    {
        $this->info('Envoi des rappels de deadline...');
        
        // Rappel 3 jours avant
        $this->sendReminders(3);
        
        // Rappel 1 jour avant
        $this->sendReminders(1);
        
        $this->info('Rappels envoyés avec succès!');
    }
    
    protected function sendReminders(int $days)
    {
        $targetDate = Carbon::now()->addDays($days)->format('Y-m-d');
        
        $assignments = Assignment::where('completed', false)
            ->whereDate('deadline', $targetDate)
            ->with('user')
            ->get();
        
        foreach ($assignments as $assignment) {
            /** @var \App\Models\Assignment $assignment */
            $assignment->user->notify(
                new DeadlineReminderNotification($assignment, $days)
            );
            
            $this->line("Rappel envoyé à {$assignment->user->email} pour '{$assignment->title}'");
        }
    }
}
