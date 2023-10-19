<?php

namespace Kareem\TA\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Kareem\Ta\Service\LocationManager;

#[AsCommand(
    name: 'app:download-locations',
    hidden: false,
    aliases: ['app:download-locations']
)]
class DownloadCommand extends Command 
{ 
    protected static $defaultDescription = "";

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln([
            'Starting to download the csv database',
            "This will take a few minutes",
            "============================="
        ]);

        $service = new LocationManager();
        $service->init();
        
        $output->writeln([
            'Completed'
        ]);

        return Command::SUCCESS;
    }

    protected function configure(): void {
        
    }
}