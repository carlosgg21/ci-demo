<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AppReset extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'app:reset';
    protected $description = 'Runs migrate:refresh and then seeds MainSeeder.';
    protected $usage       = 'app:reset';
    protected $arguments   = [];
    protected $options     = [];

    public function run(array $params)
    {
        CLI::write('Starting app:reset — migrate:refresh then db:seed MainSeeder', 'yellow');

        try {
            CLI::write('Running migrations: migrate:refresh', 'yellow');
            $this->call('migrate:refresh');
        } catch (\Throwable $e) {
            $this->showError($e);
            return EXIT_ERROR;
        }

        try {
            CLI::write('Seeding: MainSeeder', 'yellow');
            $this->call('db:seed', ['MainSeeder']);
        } catch (\Throwable $e) {
            $this->showError($e);
            return EXIT_ERROR;
        }

        CLI::write('app:reset completed successfully.', 'green');
        return EXIT_SUCCESS;
    }
}
