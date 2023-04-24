<?php

/**
 * Конфигурация для подключения к базе данных.
 */
return [
    /**
     * Тип подключения, Medoo поддерживает: sqlite, mssql, mariadb, mysql
     */
    'type' => $_ENV['DB_TYPE'] ?? 'mysql',

    /**
     * Хочт подключения.
     */
    'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',

    /**
     * Название баз данных.
     */
    'database' => $_ENV['DB_NAME'] ?? null,

    /**
     * Имя пользователя.
     */
    'username' => $_ENV['DB_USERNAME'] ?? null,

    /**
     * Пароль.
     */
    'password' => $_ENV['DB_PASSWORD'] ?? null,
];