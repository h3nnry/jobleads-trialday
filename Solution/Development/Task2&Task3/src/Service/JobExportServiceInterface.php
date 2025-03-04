<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\JobExportFormat;


interface JobExportServiceInterface
{
    public function export(JobExportFormat $jobExportFormat): string;
}
