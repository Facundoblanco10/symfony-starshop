<?php
// src/Command/CreateUsersTableCommand.php

namespace App\Command;

use App\Service\MedooClient;
use Medoo\Medoo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:create-users-table',
    description: 'Crea la tabla users en la base de datos',
)]
class CreateUsersTableCommand extends Command
{
    private Medoo $db;

    public function __construct(MedooClient $medooClient)
    {
        parent::__construct();
        $this->db = $medooClient->getClient();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        

        $output->writeln('<info>Tabla `users` creada correctamente (si no existía).</info>');


        $output->writeln('<info>10 usuarios de prueba insertados.</info>');

        return Command::SUCCESS;
    }
}
