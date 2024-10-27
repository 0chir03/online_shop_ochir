<?php

namespace Service\Logger;

class LoggerFileService implements LoggerServiceInterface
{
    public function error(string $message, array $data=[])
    {
        $dateTime = date('Y-m-d H:i:s');
        $error = implode("\n", $data);
        $log = "\n".$message."\n".$dateTime."\n".$error."\n";
        file_put_contents(__DIR__ . '/../Storage/Log/error.txt', $log, FILE_APPEND);
    }

    public function info(string $message, array $data=[])
    {
        file_put_contents(__DIR__ . '/../Storage/Log/info.txt', $log, FILE_APPEND);
    }

    public function warning(string $message, array $data=[])
    {
        file_put_contents(__DIR__ . '/../Storage/Log/warning.txt', $log, FILE_APPEND);
    }
}