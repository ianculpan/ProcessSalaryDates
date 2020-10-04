<?php

namespace App\Commands;

use App\Controller\OutputController;
use App\Models\SalaryDateModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessCSVFile extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:process-csv';

    protected function configure()
    {
        $this->setDescription('Process Salary Dates into a csv file')->setHelp('Process Salary Dates into a csv file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            '===========================',
            'Processing Salary Dates CSV',
            '===========================',
            '',
        ]);

        $salaryModel = new SalaryDateModel();
        $outputController = new OutputController();
        $outputController->writeCSVFile($salaryModel->generateData());

        $output->writeln([
            '========================',
            'Written Salary Dates CSV',
            '========================',
            '',
        ]);

        return Command::SUCCESS;
    }

}