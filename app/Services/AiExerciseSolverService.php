<?php

namespace App\Services;

use App\Models\ExerciseSolution;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class AiExerciseSolverService
{
    /**
     * Solve an exercise using OpenAI
     */
    public function solveExercise(
        int $userId,
        string $subject,
        string $problemStatement,
        string $detailLevel = 'detailed',
        ?string $imagePath = null
    ): string {
        // Build the prompt for OpenAI
        $prompt = $this->buildPrompt($subject, $problemStatement, $detailLevel);

        try {
            // Check if we have an image (future implementation: use GPT-4 Vision)
            // For now, only text-based solving
            $response = OpenAI::chat()->create([
                'model' => $this->getModel(),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un tuteur pédagogique expert. Tu donnes la solution étape par étape. Tu expliques le POURQUOI et le COMMENT. Tu utilises le format Markdown pour les maths (LaTeX) et la mise en page.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.3, // Lower temperature for more precise answers
                'max_tokens' => 2000,
            ]);

            $solutionContent = $response->choices[0]->message->content;

            // Save to database
            try {
                ExerciseSolution::create([
                    'user_id' => $userId,
                    'subject' => $subject,
                    'problem_statement' => $problemStatement,
                    'solution_content' => $solutionContent,
                    'image_path' => $imagePath,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save exercise solution: ' . $e->getMessage());
            }

            return $solutionContent;

        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            
            // Fallback to mock generation
            return $this->generateMockSolution($userId, $subject, $problemStatement);
        }
    }

    private function buildPrompt(string $subject, string $problemStatement, string $detailLevel): string
    {
        $prompt = "Résous cet exercice de **{$subject}** de manière **{$detailLevel}**.\n\n";
        $prompt .= "📝 **Énoncé**:\n{$problemStatement}\n\n";
        
        $prompt .= "**Format de réponse attendu**:\n";
        $prompt .= "1. **Identification du problème**: Quel type de problème est-ce ? Quelle formule utiliser ?\n";
        $prompt .= "2. **Étapes de résolution**: Démonstration claire, étape par étape.\n";
        $prompt .= "3. **Solution finale**: La réponse encadrée ou mise en évidence.\n";
        $prompt .= "4. **Concepts clés**: Bref rappel des notions utilisées.\n";
        
        return $prompt;
    }

    private function generateMockSolution(int $userId, string $subject, string $problemStatement): string
    {
        $mockContent = "# ✨ Solution Démontrée (Mode Démo)\n\n";
        $mockContent .= "_Note: Le service IA est indisponible. Voici une simulation basée sur votre énoncé._\n\n";

        $mockContent .= "## 🎯 Identification\n";
        $mockContent .= "Votre problème concerne le sujet **{$subject}**.\n";
        $mockContent .= "Énoncé analysé : _\"" . substr($problemStatement, 0, 100) . "...\"_\n\n";
        
        $mockContent .= "## 📝 Résolution étape par étape\n";
        $mockContent .= "1. **Analyse des données**: Nous avons identifié les termes clés dans votre énoncé.\n";
        $mockContent .= "2. **Application de la méthode**: Pour ce type de problème en {$subject}, nous appliquons la méthode standard.\n";
        $mockContent .= "3. **Résultat**: La solution découle logiquement des étapes précédentes.\n\n";
        
        $mockContent .= "## ✅ Réponse Finale\n";
        $mockContent .= "> [Réponse simulée pour : {$problemStatement}]\n\n";
        
        $mockContent .= "⚠️ **Attention** : Configurez une clé API OpenAI valide pour obtenir la véritable solution résolution mathématique.";

        try {
            ExerciseSolution::create([
                'user_id' => $userId,
                'subject' => $subject,
                'problem_statement' => $problemStatement,
                'solution_content' => $mockContent,
                'is_mock' => true,
            ]);
        } catch (\Exception $e) {
            // Ignore
        }

        return $mockContent;
    }

    private function getModel(): string
    {
        $model = env('OPENAI_MODEL', 'gpt-4o-mini');
        // Sanitize: remove comments starting with # or spaces
        $model = explode('#', $model)[0];
        return trim($model);
    }
}
