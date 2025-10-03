<?php
// Принимаем POST-запрос с данными вебхука (имитация)
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['error' => 'Нет данных']);
    exit;
}

// Файл для хранения логов
$logFile = __DIR__ . '/deal_log.json';

// Загружаем существующие данные
$logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];

// Структура входящего вебхука (пример):
// $data = [
//   'deal_id' => 101,
//   'stage_id' => 'NEW',
//   'user_id' => 12,
//   'user_name' => 'Иван Иванов',
//   'date_time' => '2025-10-03T12:34:56'
// ];

$dealId = $data['deal_id'];
if (!isset($logs[$dealId])) {
    $logs[$dealId] = [];
}

// Добавляем событие
$logs[$dealId][] = [
    'stage_id' => $data['stage_id'],
    'who_changed_id' => $data['user_id'],
    'who_changed_name' => $data['user_name'],
    'date_time' => $data['date_time']
];

// Сохраняем обратно
file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(['status' => 'ok']);
