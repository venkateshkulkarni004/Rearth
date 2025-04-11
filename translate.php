<?php
header('Content-Type: application/json');

// Function to translate text using Google Translate API
function translateText($text, $targetLang) {
    $apiKey = 'YOUR_GOOGLE_TRANSLATE_API_KEY'; // Replace with your actual API key
    $url = 'https://translation.googleapis.com/language/translate/v2';
    
    $data = array(
        'q' => $text,
        'target' => $targetLang,
        'source' => 'en',
        'key' => $apiKey
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'] ?? '';
    $targetLang = $_POST['targetLang'] ?? 'ja';
    
    if (!empty($text)) {
        $result = translateText($text, $targetLang);
        echo json_encode([
            'success' => true,
            'translatedText' => $result['data']['translations'][0]['translatedText'] ?? ''
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No text provided'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method'
    ]);
}
?> 