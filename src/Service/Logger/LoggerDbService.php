<?php

namespace Service\Logger;

use Model\Log;
class LoggerDbService implements LoggerServiceInterface
{
    public function error(string $info, array $data=[])
    {

        $dateTime = date('Y-m-d H:i:s');
        $message = $data['message'];
        $file = $data['file'];
        $line = $data['line'];

        Log::create($message, $info, $dateTime, $line, $file);

    }

    public function info(string $info, array $data=[])
    {

    }

    public function warning(string $info, array $data=[])
    {

    }
}