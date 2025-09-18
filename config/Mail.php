<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/../services/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../services');
$dotenv->load();

return [
    'host'       => $_ENV['MAIL_HOST'],
    'port'       => $_ENV['MAIL_PORT'],
    'username'   => $_ENV['MAIL_USERNAME'],
    'password'   => $_ENV['MAIL_PASSWORD'],
    'from'       => $_ENV['MAIL_FROM'],
    'from_name'  => $_ENV['MAIL_FROM_NAME'],
];
