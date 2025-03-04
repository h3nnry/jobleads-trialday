<?php

declare(strict_types=1);

namespace App\Command;

use App\Enum\JobExportFormat;
use App\Exception\JobExportFailure;
use App\JobExportStrategies\ExportStrategyInterface;
use App\Service\JobExportServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:jobexport',
    description: 'Export jobs from database',
)]
class JobExportCommand extends Command
{
    public function __construct(
        private JobExportServiceInterface $jobExportService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('format', InputArgument::REQUIRED,
                sprintf('Export format: %s.', $this->getExportFormatsAsString())
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $format = $input->getArgument('format');

        if (!in_array($format, $this->getExportFormatsAsArray())) {
            $io->error(sprintf('Invalid format. Allowed values: %s.', $this->getExportFormatsAsString()));
            return Command::FAILURE;
        }

        try {
            $this->jobExportService->export(JobExportFormat::tryFrom($format));
            $io->success("Jobs exported successfully in $format format.");

            return Command::SUCCESS;
        } catch (JobExportFailure $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }

    private function getExportFormatsAsArray(): array
    {
        return array_column(JobExportFormat::cases(), 'value');
    }

    private function getExportFormatsAsString(): string
    {
        return implode(', ', $this->getExportFormatsAsArray());
    }
}
