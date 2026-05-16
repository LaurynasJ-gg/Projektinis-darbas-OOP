<?php

class Database
{
    private string $connection = 'mysql';
    private string $host = 'localhost';
    private string $dbName = 'php_projektas';
    private string $username = 'root';
    private string $password = '';

    private ?PDO $conn = null;

    public function connect(): PDO
    {
        if ($this->conn === null) {
            try {
                $dsn = "{$this->connection}:host={$this->host};dbname={$this->dbName};charset=utf8mb4";

                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die('Nepavyko prisijungti prie duomenų bazės- ' . $e->getMessage());
            }
        }

        return $this->conn;
    }
}