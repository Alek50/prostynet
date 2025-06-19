<?php
header('Content-Type: application/json');
$filename = 'checklist.json';

// Inicjalizacja pliku
if (!file_exists($filename)) {
    file_put_contents($filename, json_encode([
        ["content" => "Utworzenie checklisty", "done" => true],
        ["content" => "Integracja z AI", "done" => false],
    ], JSON_PRETTY_PRINT));
}

// Odczyt danych
$data = json_decode(file_get_contents($filename), true);

// Zwróć listę
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['suggestions'])) {
        echo json_encode([
            ["content" => "Dodaj harmonogram spotkań AI"],
            ["content" => "Wprowadź system głosowania nad pomysłami"],
            ["content" => "Integruj z Google Calendar"]
        ]);
    } else {
        echo json_encode($data);
    }
    exit;
}

// Dodanie nowego elementu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!isset($input['content'])) {
        http_response_code(400);
        echo json_encode(["error" => "Brak treści zadania."]);
        exit;
    }
    $data[] = ["content" => $input['content'], "done" => false];
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    echo json_encode(["success" => true]);
    exit;
}
?>