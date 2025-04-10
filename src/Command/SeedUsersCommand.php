<?php

namespace App\Command;

use App\Service\MedooClient;
use Faker\Factory as Faker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:seed-users',
    description: 'Inserta 10 usuarios de prueba en la base de datos',
)]
class SeedUsersCommand extends Command
{
    private $db;

    public function __construct(MedooClient $medooClient)
    {
        parent::__construct();
        $this->db = $medooClient->getClient();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $this->db->insert('users', [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => password_hash('password123', PASSWORD_BCRYPT),
            ]);
        }

        $output->writeln('<info>Se insertaron 10 usuarios de prueba correctamente.</info>');

        return Command::SUCCESS;
    }
}
