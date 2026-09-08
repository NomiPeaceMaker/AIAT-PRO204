<?php

function getDbConfig(): array
{
    return [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'YourNewPassword123!',
        'dbname' => 'php_crud_app',
    ];
}

function initializeDatabase(): string
{
    $config = getDbConfig();
    $host = $config['host'];
    $user = $config['user'];
    $pass = $config['pass'];
    $dbname = $config['dbname'];

    try {
        $serverPdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $result = $serverPdo->query("SHOW DATABASES LIKE '{$dbname}'")->fetch();

        if ($result === false) {
            $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}`");
            $status = 'Database created successfully.';
        } else {
            $status = 'Using the existing database.';
        }

        $connection = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $connection->exec(
            "CREATE TABLE IF NOT EXISTS contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                phone VARCHAR(30) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )"
        );

        return $status;
    } catch (PDOException $e) {
        die(
            'Database connection error: ' . $e->getMessage() . '<br>' .
            'Check your MySQL username/password in the local setup. <br>' .
            'If using XAMPP/WAMP, use the correct root password or create a database user for this app.'
        );
    }
}

function getConnection(): PDO
{
    $config = getDbConfig();

    return new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
        $config['user'],
        $config['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}
