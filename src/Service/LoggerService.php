<?php

namespace Service;

use Exception;
class LoggerService
{
    private Exception $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function log()
    {
        $message = $this->exception->getMessage();
        $file = $this->exception->getFile();
        $line = $this->exception->getLine();
        $log = "\n".date('Y-m-d H:i:s')."\n".$message."\n".$file."\n".$line;

        file_put_contents(__DIR__ . '/../Storage/Log/error.txt', $log, FILE_APPEND);
    }
}