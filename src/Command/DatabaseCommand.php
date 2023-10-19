<?php

namespace Kareem\TA\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Kareem\Ta\App\SQLiteConnection;

#[AsCommand(
    name: 'app:db-restore',
    hidden: false,
    aliases: ['app:db-restore']
)]
class DatabaseCommand extends Command 
{ 
    protected static $defaultDescription = "New Database";

    private $db;

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln([
            'Starting to restore the database'
        ]);
        // creates a new progress bar (50 units)
        $progressBar = new ProgressBar($output, 50);

        // starts and displays the progress bar
        $progressBar->start();

        $i = 0;
        while ($i++ < 50) {
            $this->db = (SQLiteConnection::getinstance())->getConnection();

            $sqlDrop = "DROP TABLE IF EXISTS locations";
            $this->db->exec($sqlDrop);

            $sqlCreate = "CREATE TABLE IF NOT EXISTS locations (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                postcode TEXT NOT NULL,
                latitude REAL NOT NULL,
                longitude REAL NOT NULL
            )";

            $this->db->exec($sqlCreate);
            $progressBar->advance();
        }

        // ensures that the progress bar is at 100%
        $progressBar->finish();
        $output->writeln([
            'Completed'
        ]);

        return Command::SUCCESS;
    }

    protected function configure(): void {
        
    }
}