CREATE DATABASE IF NOT EXISTS `laravel_test` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Użytkownik taki jak w .env
GRANT ALL PRIVILEGES ON `laravel_test`.* TO 'sail'@'%' IDENTIFIED BY 'password';
FLUSH PRIVILEGES;
