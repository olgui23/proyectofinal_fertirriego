<?php

namespace App\Services;

class LoggerSingleton
{
    private $logFile;

    public function __construct()
    {
        $this->logFile = storage_path('logs/auditoria.log');
    }

    public function log($message)
    {
        $timestamp = now()->toDateTimeString();
        $logMessage = "[$timestamp] $message\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}
