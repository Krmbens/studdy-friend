<?php

namespace App\Services;

use App\Models\FlashcardDeck;
use App\Models\Flashcard;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class AiFlashcardService
{
    public function generateDeck(
        int $userId,
        string $topic,
        string $content, // Source text to generate from
        int $count = 10
    ): FlashcardDeck {
        $prompt = $this->buildPrompt($topic, $content, $count);

        try {
            $response = OpenAI::chat()->create([
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un générateur de flashcards. Tu renvoies UNIQUEMENT du JSON valide.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.5,
                'response_format' => ['type' => 'json_object'],
            ]);

            $jsonContent = $response->choices[0]->message->content;
            $data = json_decode($jsonContent, true);

            // Create Deck
            $deck = FlashcardDeck::create([
                'user_id' => $userId,
                'name' => $topic,
                'subject' => 'Général', // Could be inferred
                'total_cards' => count($data['cards']),
            ]);

            // Save Cards
            foreach ($data['cards'] as $card) {
                Flashcard::create([
                    'flashcard_deck_id' => $deck->id,
                    'front_content' => $card['front'],
                    'back_content' => $card['back'],
                ]);
            }

            return $deck;

        } catch (\Exception $e) {
            Log::error('AI Flashcard Error: ' . $e->getMessage());
            return $this->generateMockDeck($userId, $topic, $content);
        }
    }

    private function buildPrompt($topic, $content, $count): string
    {
        return <<<EOT
Crée {$count} flashcards sur le sujet "{$topic}" basées sur le texte suivant.
Langue: Français.

Texte:
{$content}

Format JSON requis:
{
    "cards": [
        {
            "front": "Question ou Terme (Recto)",
            "back": "Réponse ou Définition (Verso)"
        }
    ]
}
EOT;
    }

    private function generateMockDeck($userId, $topic, $content): FlashcardDeck
    {
        $deck = FlashcardDeck::create([
            'user_id' => $userId,
            'name' => "Deck : $topic",
            'subject' => 'Général',
            'total_cards' => 5,
            'is_mock' => true,
        ]);

        // Simple mock logic: split by periods to find sentences, use first word as "Term" and rest as "Definition"
        $sentences = preg_split('/(?<=[.?!])\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $count = 0;

        foreach ($sentences as $sentence) {
            if ($count >= 5) break;
            $sentence = trim($sentence);
            if (strlen($sentence) < 10) continue;

            // Simple heuristic for demo: 
            // Front: First 3-4 words? Or "Concept form TEXT"
            // Let's try to grab the first noun-phrase-like chunk (first 5 words) as the prompt
            $words = explode(' ', $sentence);
            $front = implode(' ', array_slice($words, 0, min(4, count($words)))) . '... ?';
            $back = $sentence;

            Flashcard::create([
                'flashcard_deck_id' => $deck->id,
                'front_content' => $front,
                'back_content' => $back,
            ]);
            $count++;
        }
        
        // If text was too short, fill with generic
        while ($count < 5) {
             $count++;
             Flashcard::create([
                'flashcard_deck_id' => $deck->id,
                'front_content' => "Concept supplémentaire #{$count}",
                'back_content' => "Information importante concernant $topic.",
            ]);
        }

        return $deck;
    }
}
