<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Str;

class AiQuizService
{
    public function generateQuiz(
        int $userId,
        string $subject,
        string $topic, // or chapter
        int $numQuestions = 5,
        string $difficulty = 'Medium',
        ?string $sourceContent = null // New parameter
    ): Quiz {
        $prompt = $this->buildPrompt($subject, $topic, $numQuestions, $difficulty, $sourceContent);

        try {
            $response = OpenAI::chat()->create([
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Tu es un générateur de quiz éducatif. Tu renvoies UNIQUEMENT du JSON valide, sans markdown ni texte autour.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'response_format' => ['type' => 'json_object'], // Force JSON mode
            ]);

            $jsonContent = $response->choices[0]->message->content;
            $data = json_decode($jsonContent, true);

            // Create Quiz
            $quiz = Quiz::create([
                'user_id' => $userId,
                'title' => "Quiz: $topic",
                'subject' => $subject,
                'total_score' => $numQuestions * 10,
            ]);

            // Save Questions
            foreach ($data['questions'] as $q) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $q['question'],
                    'type' => 'multiple_choice',
                    'options' => $q['options'], // Model cast handles array to JSON
                    'correct_answer' => $q['correct_answer'],
                    'explanation' => $q['explanation'] ?? null,
                ]);
            }

            return $quiz;

        } catch (\Exception $e) {
            Log::error('AI Quiz Error: ' . $e->getMessage());
            return $this->generateMockQuiz($userId, $subject, $topic);
        }
    }

    private function buildPrompt($subject, $topic, $num, $difficulty, $sourceContent = null): string
    {
        $prompt = "Génère un quiz de {$num} questions sur le sujet \"{$subject} - {$topic}\".\n";
        $prompt .= "Difficulté: {$difficulty}.\n";
        $prompt .= "Langue: Français.\n\n";

        if ($sourceContent) {
            $prompt .= "**BASER LE QUIZ SUR CE TEXTE SPÉCIFIQUE**:\n";
            $prompt .= $sourceContent . "\n\n";
        }

        $prompt .= "Format JSON requis:\n";
        $prompt .= "{\n";
        $prompt .= "    \"questions\": [\n";
        $prompt .= "        {\n";
        $prompt .= "            \"question\": \"Texte de la question ?\",\n";
        $prompt .= "            \"options\": [\"Option A\", \"Option B\", \"Option C\", \"Option D\"],\n";
        $prompt .= "            \"correct_answer\": \"Option A\",\n";
        $prompt .= "            \"explanation\": \"Pourquoi c'est la bonne réponse.\"\n";
        $prompt .= "        }\n";
        $prompt .= "    ]\n";
        $prompt .= "}\n";

        return $prompt;
    }

    private function generateMockQuiz($userId, $subject, $topic): Quiz
    {
        $quiz = Quiz::create([
            'user_id' => $userId,
            'title' => "Quiz : $topic",
            'subject' => $subject,
            'total_score' => 50,
            'is_mock' => true,
        ]);

        $mockQuestions = [
            "Quel est le concept principal de $topic ?",
            "Parmi les suivants, lequel est lié à $topic ?",
            "Vrai ou Faux : $topic est un sujet fondamental en $subject.",
            "Quelle est une application pratique de $topic ?",
            "Expliquez brièvement l'importance de $topic."
        ];

        foreach ($mockQuestions as $index => $qText) {
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question_text' => $qText,
                'options' => ["Option A", "Option B", "Option C", "Option D"],
                'correct_answer' => "Option A",
                'explanation' => "Ceci est une explication simulée car l'API n'est pas disponible.",
            ]);
        }
        return $quiz;
    }
}
