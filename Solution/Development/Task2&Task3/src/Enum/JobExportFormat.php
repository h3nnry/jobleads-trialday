<?php

namespace App\Enum;

enum JobExportFormat: string
{
    case CSV = 'csv';
    case XML = 'xml';
    case XML_LIMITED = 'xml-limited';
}
