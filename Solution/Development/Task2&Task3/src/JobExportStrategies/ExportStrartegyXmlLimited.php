<?php

declare(strict_types=1);

namespace App\JobExportStrategies;

use App\Entity\Job;
use App\Enum\JobExportFormat;
use XMLWriter;

class ExportStrartegyXmlLimited extends ExportStrartegyXml
{
    protected array $serializerOptions = [
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
