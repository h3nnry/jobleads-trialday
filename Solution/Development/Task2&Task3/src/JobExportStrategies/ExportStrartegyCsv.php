<?php

declare(strict_types=1);

namespace App\JobExportStrategies;

use App\Enum\JobExportFormat;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ExportStrartegyCsv implements ExportStrategyInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function getFileExtension(): string
    {
        return 'csv';
    }
    public function supports(string $format): bool
    {
        return $format === JobExportFormat::CSV->value;
    }

    public function export(iterable $data, string $file): void
    {
        $fileHandler = fopen($file, 'w');

        foreach ($data as $entity) {
            fwrite($fileHandler, $this->serializer->serialize($entity, 'csv', ['no_headers' => true]));
        }

        fclose($fileHandler);
    }

}
