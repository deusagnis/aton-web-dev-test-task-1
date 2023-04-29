<?php

/**
 * Общая конфигурация приложения.
 */
return [
    /**
     * Флаг режима отладки. Если истина - в ошибках отображается sensitive данные.
     */
    'debug' => filter_var($_ENV['DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),

    /**
     * Флаг запуска на продакшене. Если истина - то будет подключаться фронтенд
     * из файла ./public/js/dist/app.min.js. Иначе ./public/js/src/index.js
     */
    'prod' => filter_var($_ENV['PROD'] ?? false, FILTER_VALIDATE_BOOLEAN),

    /**
     * Префикс папки точки входа в приложение для сервера.
     */
    'publicPrefix' => $_ENV['PUBLIC_PREFIX'] ?? "",

    /**
     * Номер-ключ сборки клиентского приложения.
     * Нужен для управления кешированием файлов при загрузке на страницу.
     */
    'uiKey' => $_ENV['UI_KEY'] ?? "0",
];