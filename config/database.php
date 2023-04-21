<?php

return [
    'type' => $_ENV['DB_TYPE'] ?? 'mysql',
    'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'database' => $_ENV['DB_NAME'] ?? null,
    'username' => $_ENV['DB_USERNAME'] ?? null,
    'password' => $_ENV['DB_PASSWORD'] ?? null,
];