<?php

/**
 * Общая конфигурация приложения.
 */
return [
    /**
     * Флаг режима отладки. Если истина - в ошибках отображается sensitive данные.
     */
    'debug' => filter_var($_ENV['DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
];