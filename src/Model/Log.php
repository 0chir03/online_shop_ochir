<?php

namespace Model;

class Log extends Model
{
    public static function create(string $message, string $info, string $dateTime,  int $line, string $file)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO  logs  (message, info, date_time,  line, file) VALUES (:message, :info, :dateTime, :line, :file)");
        $stmt->execute(['message' => $message, 'info' => $info, 'dateTime' => $dateTime, 'line' => $line, 'file' => $file]);
    }
}