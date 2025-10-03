<?php
$logFile = __DIR__ . '/deal_log.json';
$logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];

// Формируем ассоциативный массив
$result = [];
foreach ($logs as $dealId => $events) {
    foreach ($events as $event) {
        $result[$dealId][$event['stage_id']] = [
            'user_id' => $event['who_changed_id'],
            'user_name' => $event['who_changed_name'],
            'date_time' => $event['date_time']
        ];
    }
}

// Вывод JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
