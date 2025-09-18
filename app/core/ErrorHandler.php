<?php
class ErrorHandler {
    public static function register() {
        // Show errors only in development
        ini_set('display_errors', 0); 
        ini_set('log_errors', 1);
        ini_set('error_log', __DIR__ . '/../../logs/error.log');

        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
    }

    public static function handleException($e) {
        error_log($e); // write to logs/error.log

        http_response_code(500);
        include __DIR__ . '/../views/errors/500.php';
        exit;
    }

    public static function handleError($severity, $message, $file, $line) {
        error_log("Error: [$severity] $message in $file on line $line");

        http_response_code(500);
        include __DIR__ . '/../views/errors/500.php';
        exit;
    }
}
