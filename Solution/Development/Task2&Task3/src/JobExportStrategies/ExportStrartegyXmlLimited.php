<?php

declare(strict_types=1);

namespace App\JobExportStrategies;

use App\Enum\JobExportFormat;

readonly class ExportStrartegyXmlLimited extends ExportStrartegyXml
{
    protected const SERIALIZER_OPTIONS = [
        'encoder_ignored_node_types' => [
            XML_PI_NODE,
        ],
        'properties' => ['name', 'description', 'company'],
        'use_string_slice' => true,
    ];
    public function supports(string $format): bool
    {
        return $format === JobExportFormat::XML_LIMITED->value;
    }
}
