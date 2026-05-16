<?php

class Database
{
    private ?PDO $conn = null;

    private function getEnvValue(string $key): string
    {
        $envPath = __DIR__ . '/../.env'; 

        if (!file_exists($envPath)) {
            die('.env failas nerastas.');
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with($line, $key . '=')) {
                return trim(str_replace($key . '=', '', $line));
            }
        }

        return '';
    }

    public function connect(): PDO
    {
        if ($this->conn === null) {
            try {
                $connection = $this->getEnvValue('DB_CONNECTION');
                $host = $this->getEnvValue('DB_HOST');
                $dbName = $this->getEnvValue('DB_NAME');
                $username = $this->getEnvValue('DB_USER');
                $password = $this->getEnvValue('DB_PASS');

                $dsn = "{$connection}:host={$host};dbname={$dbName};charset=utf8mb4";

                $this->conn = new PDO($dsn, $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die('Nepavyko prisijungti prie duomenų bazės- ' . $e->getMessage());
            }
        }

        return $this->conn;
    }
}