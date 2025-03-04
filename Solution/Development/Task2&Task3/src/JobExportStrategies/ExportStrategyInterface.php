<?php

declare(strict_types=1);

namespace App\JobExportStrategies;

interface ExportStrategyInterface
{
    public function supports(string $format): bool;
    public function export(iterable $data, string $file): void;

    public function getFileExtension(): string;
}
