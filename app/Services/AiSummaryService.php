<?php

namespace App\Services;

use App\Models\DocumentSummary;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class AiSummaryService
{
    public function generateSummary(
        int $userId,
        string $content,
        string $style = 'key_points', // key_points, concise, elaborate
        string $language = 'French'
    ): string {
        $prompt = $this->buildPrompt($content, $style, $language);

        try {
            $response = OpenAI::chat()->create([
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un expert en synthèse de documents. Tu extrais l\'information essentielle de manière claire et structurée.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.4,
                'max_tokens' => 1500,
            ]);

            $summaryContent = $response->choices[0]->message->content;

            // Save to DB
            DocumentSummary::create([
                'user_id' => $userId,
                'original_content' => substr($content, 0, 10000),
                'summary_content' => $summaryContent,
                'original_length' => strlen($content),
                'summary_length' => strlen($summaryContent),
                'is_mock' => false,
            ]);

            return $summaryContent;

        } catch (\Exception $e) {
            Log::error('AI Summary Error: ' . $e->getMessage());
            $mockSummary = $this->generateMockSummary($content);
            
            DocumentSummary::create([
                'user_id' => $userId,
                'original_content' => substr($content, 0, 10000),
                'summary_content' => $mockSummary,
                'original_length' => strlen($content),
                'summary_length' => strlen($mockSummary),
                'is_mock' => true,
            ]);

            return $mockSummary;
        }
    }

    private function buildPrompt(string $content, string $style, string $language): string
    {
        $prompt = "Résume le texte suivant en **{$language}**.\n";
        $prompt .= "Style: **{$style}** (Format structuré avec des points clés si possible).\n\n";
        $prompt .= "TEXTE ORIGINAL:\n" . substr($content, 0, 8000) . "\n\n"; // Limit prompt size
        $prompt .= "INSTRUCTIONS:\n";
        $prompt .= "- Identifie les concepts principaux.\n";
        $prompt .= "- Ignore les détails superflus.\n";
        $prompt .= "- Utilise des listes à puces pour la lisibilité.\n";
        return $prompt;
    }

    private function generateMockSummary(string $content): string
    {
        // Simple extraction of first few sentences as a "summary"
        $sentences = preg_split('/(?<=[.?!])\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $summaryPoints = array_slice($sentences, 0, 3);
        
        $mockOutput = "## 📝 Résumé (Mode Démo)\n\n";
        $mockOutput .= "_Note : Le service IA est momentanément indisponible (Quota/Rate Limit). Voici un extrait généré localement._\n\n";
        
        foreach ($summaryPoints as $point) {
            $mockOutput .= "- " . trim($point) . "\n";
        }
        
        if (count($sentences) > 3) {
            $mockOutput .= "\nTry adding a valid API key to enable full AI analysis.";
        }

        return $mockOutput;
    }
}
