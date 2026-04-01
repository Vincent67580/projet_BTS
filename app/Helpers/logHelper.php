<?php

function writeLog(string $action, array $context = []): void
{
    $logDir  = BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs';
    $logFile = $logDir . DIRECTORY_SEPARATOR . 'app.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $date      = date('d/m/Y H:i:s');
    $ip        = $_SERVER['REMOTE_ADDR'] ?? 'inconnue';
    $contexte  = !empty($context) ? json_encode($context, JSON_UNESCAPED_UNICODE) : '';

    $ligne = "[$date] [$ip] $action $contexte" . PHP_EOL;

    file_put_contents($logFile, $ligne, FILE_APPEND | LOCK_EX);
}