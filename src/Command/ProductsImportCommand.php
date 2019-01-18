<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProductsImportCommand extends Command
{
    protected static $defaultName = 'app:products:import';

    protected function configure()
    {
        $this
            ->setDescription('Import product from JSON file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo 'Hello world ! ' . PHP_EOL;
    }
}
