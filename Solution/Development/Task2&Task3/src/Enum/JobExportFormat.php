<?php

namespace App\Enum;

enum JobExportFormat: string
{
    case CSV = 'csv';
    case XML = 'xml';
    case XML_LIMITED = 'xml-limited';

    public static function getExportFormatsAsArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getExportFormatsAsString(): string
    {
        return implode(', ', self::getExportFormatsAsArray());
    }
}
