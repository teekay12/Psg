<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Kareem\Ta\Command\DownloadCommand;
use Kareem\Ta\Command\DatabaseCommand;

$application = new Application();

$application->add(new DownloadCommand());
$application->add(new DatabaseCommand());

$application->run();

?>