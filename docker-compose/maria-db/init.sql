# Создание базы данных для продуктов, если БД с таким именем нет.
CREATE DATABASE IF NOT EXISTS aton_test
    CHARACTER SET = 'utf8mb4'
    COLLATE = 'utf8mb4_unicode_ci'