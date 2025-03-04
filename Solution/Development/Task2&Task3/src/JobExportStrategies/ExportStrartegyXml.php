<?php

declare(strict_types=1);

namespace App\JobExportStrategies;

use App\Enum\JobExportFormat;
use XML_PI_NODE;
use Symfony\Component\Serializer\SerializerInterface;

class ExportStrartegyXml implements ExportStrategyInterface
{
    protected array $serializerOptions = [
        'encoder_ignored_node_types' => [
            XML_PI_NODE,
        ],
        'use_string_slice' => false,
    ];

    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function getFileExtension(): string
    {
        return 'xml';
    }

    public function supports(string $format): bool
    {
        return $format === JobExportFormat::XML->value;
    }

    public function export(iterable $data, string $file): void
    {
        $fileHandler = fopen($file, 'w');
        fwrite($fileHandler, "<?xml version=\"1.0\"?><root>");

        foreach ($data as $entity) {

            $xmlChunk = $this->serializer->serialize($entity, 'xml', $this->serializerOptions);
            fwrite($fileHandler, $xmlChunk);
        }

        fwrite($fileHandler, "</root>");
        fclose($fileHandler);
    }


    protected function getColumn(string $column): string
    {
        return $column;
    }

}
