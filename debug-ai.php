<?php

require __DIR__ . '/vendor/autoload.php';

$lines = file(__DIR__ . '/.env');
$env = [];
foreach ($lines as $line) {
    if (trim($line) === '' || strpos(trim($line), '#') === 0) continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2) {
        $env[trim($parts[0])] = trim($parts[1]);
    }
}

$apiKey = $env['OPENAI_API_KEY'] ?? null;
$baseUrl = $env['OPENAI_BASE_URL'] ?? 'api.openai.com/v1'; // Default matching config
$model = $env['OPENAI_MODEL'] ?? 'gpt-4o-mini';

echo "--- Debug Info ---\n";
echo "API Key Length: " . strlen($apiKey) . "\n";
echo "Base URL: " . $baseUrl . "\n";
echo "Model: " . $model . "\n";
echo "------------------\n";

if (!$apiKey) {
    echo "❌ Missing API Key in .env\n";
    exit(1);
}

try {
    $factory = OpenAI::factory()
        ->withApiKey($apiKey)
        ->withBaseUri($baseUrl)
        ->withHttpHeader('OpenAI-Beta', 'assistants=v1'); // Just in case, standard header
    
    $client = $factory->make();

    echo "Attempting connection to $baseUrl with model $model...\n";

    $response = $client->chat()->create([
        'model' => $model,
        'messages' => [
            ['role' => 'user', 'content' => 'Hello, are you working? Respond with "YES".'],
        ],
        'max_tokens' => 10,
    ]);

    echo "✅ SUCCESS! Response: " . $response->choices[0]->message->content . "\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    if (strpos($e->getMessage(), '401') !== false) {
        echo "-> Check your API Key.\n";
    }
    if (strpos($e->getMessage(), '404') !== false) {
        echo "-> Check your Base URL or Model name.\n";
    }
}
