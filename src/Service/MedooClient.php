<?php

namespace App\Service;

use Medoo\Medoo;
use PDO;

class MedooClient
{
    private Medoo $database;

    public function __construct(string $host, string $database, string $username, string $password)
    {
        $this->database = new Medoo([
            'type' => 'mysql',
            'host' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8mb4',
            'error' => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public function getClient(): Medoo
    {
        return $this->database;
    }
}