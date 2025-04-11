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

    public function create(string $name, string $email, string $password): bool
    {
        $this->logger->info("Creating new user", [
            'name' => $name,
            'email' => $email
        ]);

        return $this->database->insert("users", [
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "created_at" => (new DateTime())->format('Y-m-d H:i:s')
        ])->rowCount() > 0;
    }

    public function deleteById(int $id): bool
    {
        $this->logger->info('Deleting user by ID', ['id' => $id]);
        return $this->database->delete("users", ["id" => $id])->rowCount() > 0;   
    }

    public function updateById(int $id, array $data): bool
    {
        $this->logger->info('Updating user by ID', ['id' => $id, 'data' => $data]);

        if (empty($data)) {
            $this->logger->warning('Update aborted: no data provided');
            return false;
        }

        return $this->database->update("users", $data, ["id" => $id])->rowCount() > 0;
    }
}
