<?php

namespace App\Repository;

use App\Service\MedooClient;
use Psr\Log\LoggerInterface;
use App\Model\User;
use DateTime;
use Medoo\Medoo;

class UserRepository
{
    private Medoo $database;

    public function __construct(MedooClient $client, private LoggerInterface $logger)
    {
        $this->database = $client->getClient();
    }

    public function findAll(): array
    {
        $this->logger->info("Fetching all users");

        $data = $this->database->select("users", "*");

        return array_map(function ($row) {
            return new User(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                $row['password'],
                new DateTime($row['created_at'])
            );
        }, $data);
    }

    public function findById(int $id): ?User
    {
        $this->logger->info('Fetching user by ID', ['id' => $id]);
        $data = $this->database->get("users", "*", ["id" => $id]);
        if (!$data) {
            return null;
        }
        return new User(
            (int) $data["id"],
            $data["name"],
            $data["email"],
            $data["password"],
            new DateTime($data["created_at"])
        );
    }
}
