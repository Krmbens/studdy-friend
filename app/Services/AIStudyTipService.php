<?php

namespace App\Services;

use App\Models\AiStudyTip;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class AIStudyTipService
{
    /**
     * Generate an enhanced study plan using OpenAI
     */
    public function generateEnhancedStudyPlan(
        int $userId,
        string $subject,
        ?int $daysUntilExam,
        string $academicLevel,
        string $understandingLevel,
        int $availableHoursPerDay,
        string $learningStyle,
        ?string $difficultTopics = null,
        ?string $specificGoals = null,
        ?string $additionalNotes = null
    ): string {
        // Build the prompt for OpenAI
        $prompt = $this->buildPrompt(
            $subject,
            $daysUntilExam,
            $academicLevel,
            $understandingLevel,
            $availableHoursPerDay,
            $learningStyle,
            $difficultTopics,
            $specificGoals,
            $additionalNotes
        );

        try {
            // Call OpenAI API
            $response = OpenAI::chat()->create([
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un assistant pédagogique expert qui crée des plans d\'étude personnalisés et détaillés pour les étudiants. Tes plans sont structurés, motivants et adaptés au niveau et au style d\'apprentissage de chaque étudiant.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            $generatedContent = $response->choices[0]->message->content;

            // Save to database
            try {
                $this->saveTip(
                    $userId,
                    $subject,
                    $generatedContent,
                    $daysUntilExam,
                    [
                        'academic_level' => $academicLevel,
                        'understanding_level' => $understandingLevel,
                        'available_hours_per_day' => $availableHoursPerDay,
                        'learning_style' => $learningStyle,
                        'difficult_topics' => $difficultTopics,
                        'specific_goals' => $specificGoals,
                        'additional_notes' => $additionalNotes,
                    ]
                );
            } catch (\Exception $e) {
                // Log legacy error but don't fail generation
                Log::error('Failed to save AI tip: ' . $e->getMessage());
            }

            return $generatedContent;

        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            
            // Fallback to mock generation if API fails (e.g. rate limit, quota exceeded)
            return $this->generateMockPlan(
                $userId,
                $subject,
                $daysUntilExam,
                $academicLevel,
                $understandingLevel,
                $availableHoursPerDay,
                $learningStyle,
                $difficultTopics,
                $specificGoals,
                $additionalNotes
            );
        }
    }

    /**
     * Build the prompt for OpenAI
     */
    private function buildPrompt(
        string $subject,
        ?int $daysUntilExam,
        string $academicLevel,
        string $understandingLevel,
        int $availableHoursPerDay,
        string $learningStyle,
        ?string $difficultTopics,
        ?string $specificGoals,
        ?string $additionalNotes
    ): string {
        $prompt = "Crée un plan d'étude personnalisé et détaillé avec les informations suivantes:\n\n";
        $prompt .= "📚 **Matière**: {$subject}\n";
        $prompt .= "🎓 **Niveau d'études**: {$academicLevel}\n";
        $prompt .= "📊 **Niveau de compréhension actuel**: {$understandingLevel}\n";
        $prompt .= "⏰ **Temps disponible par jour**: {$availableHoursPerDay} heure(s)\n";
        $prompt .= "🧠 **Style d'apprentissage**: {$learningStyle}\n";

        if ($daysUntilExam) {
            $prompt .= "📅 **Jours jusqu'à l'examen**: {$daysUntilExam} jours\n";
        }

        if ($difficultTopics) {
            $prompt .= "⚠️ **Sujets difficiles**: {$difficultTopics}\n";
        }

        if ($specificGoals) {
            $prompt .= "🎯 **Objectifs spécifiques**: {$specificGoals}\n";
        }

        if ($additionalNotes) {
            $prompt .= "📝 **Notes supplémentaires**: {$additionalNotes}\n";
        }

        $prompt .= "\n**Instructions**:\n";
        $prompt .= "1. Crée un plan d'étude structuré et progressif\n";
        $prompt .= "2. Adapte le contenu au niveau et au style d'apprentissage de l'étudiant\n";
        $prompt .= "3. Inclus des techniques d'étude spécifiques et des conseils pratiques\n";
        $prompt .= "4. Propose un calendrier réaliste basé sur le temps disponible\n";
        $prompt .= "5. Donne des stratégies pour surmonter les difficultés mentionnées\n";
        $prompt .= "6. Inclus des méthodes de révision et d'auto-évaluation\n";
        $prompt .= "7. Utilise des emojis et une mise en forme claire pour rendre le plan engageant\n";
        $prompt .= "8. Termine avec des conseils de motivation et de bien-être\n";

        return $prompt;
    }

    /**
     * Save the generated tip to the database
     */
    private function saveTip(
        int $userId,
        string $subject,
        string $content,
        ?int $daysUntilExam,
        array $metadata
    ): void {
        AiStudyTip::create([
            'user_id' => $userId,
            'subject' => $subject,
            'tip_content' => $content,
            'days_until_exam' => $daysUntilExam,
            'generated_at' => now(),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Generate a mock study plan for testing/fallback
     */
    private function generateMockPlan(
        int $userId,
        string $subject,
        ?int $daysUntilExam,
        string $academicLevel,
        string $understandingLevel,
        int $availableHoursPerDay,
        string $learningStyle,
        ?string $difficultTopics = null,
        ?string $specificGoals = null,
        ?string $additionalNotes = null
    ): string {
        $mockContent = "# 📚 Plan d'étude : {$subject}\n\n";
        $mockContent .= "_(Mode démonstration - Généré localement car l'API est indisponible)_\n\n";
        
        $mockContent .= "## 🎯 Objectifs\n";
        $mockContent .= "- Maîtriser les concepts clés de {$subject}\n";
        if ($specificGoals) {
            $mockContent .= "- Atteindre votre objectif : {$specificGoals}\n";
        }
        $mockContent .= "- Adapter l'apprentissage au style **{$learningStyle}**\n\n";
        
        $mockContent .= "## 🗓️ Calendrier Suggéré\n";
        $days = $daysUntilExam ? min($daysUntilExam, 7) : 5;
        
        for ($i = 1; $i <= $days; $i++) {
            $mockContent .= "### Jour {$i}\n";
            $mockContent .= "- **Matin (1h)** : Révision des bases\n";
            $mockContent .= "- **Après-midi (" . ($availableHoursPerDay > 1 ? $availableHoursPerDay - 1 : 0.5) . "h)** : " . ($difficultTopics ? "Focus sur {$difficultTopics}" : "Exercices pratiques") . "\n";
            $mockContent .= "- **Soir (30min)** : Résumé et auto-évaluation\n\n";
        }
        
        $mockContent .= "## 💡 Conseils Personnalisés\n";
        $mockContent .= "- Utilisez des schémas et diagrammes (Style {$learningStyle})\n";
        $mockContent .= "- Faites des pauses régulières (Méthode Pomodoro)\n";
        $mockContent .= "- Restez positif et constant dans vos efforts !\n";

        // Save to database just like a real plan
        try {
            $this->saveTip(
                $userId,
                $subject,
                $mockContent,
                $daysUntilExam,
                [
                    'academic_level' => $academicLevel,
                    'understanding_level' => $understandingLevel,
                    'available_hours_per_day' => $availableHoursPerDay,
                    'learning_style' => $learningStyle,
                    'difficult_topics' => $difficultTopics,
                    'specific_goals' => $specificGoals,
                    'additional_notes' => $additionalNotes,
                    'is_mock' => true
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to save mock AI tip: ' . $e->getMessage());
        }

        return $mockContent;
    }
}