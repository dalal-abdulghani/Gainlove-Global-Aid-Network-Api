<?php
namespace App\Core;

class Logger {
    private static $logFile = __DIR__ . '/../../storage/logs/app.log';

    public static function error($message) {
        self::write('ERROR', $message);
    }

    public static function info($message) {
        self::write('INFO', $message);
    }

    private static function write($level, $message) {
        if (!is_dir(dirname(self::$logFile))) mkdir(dirname(self::$logFile), 0755, true);
        $line = "[".date('Y-m-d H:i:s')."] [$level] $message\n";
        file_put_contents(self::$logFile, $line, FILE_APPEND);
    }
}
