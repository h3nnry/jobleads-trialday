<?php

declare(strict_types=1);

namespace Development;

use Exception;

enum FileType: string {
    case CSV = 'csv';
    case TXT = 'txt';
}

interface File
{
    public function supports(string $extension): bool;

    /**
     * @return int[]
     */
    public function read(string $filename): array;
}

class FileTypeCsv implements File
{
    public function supports(string $extension): bool
    {
        return $extension === FileType::CSV->value;
    }

    public function read(string $fileName): array
    {
        $integers = [];
        $file = fopen($fileName, 'r');
        while (($data = fgetcsv($file)) !== false) {
            foreach ($data as $value) {
                $integers[] = (int) trim($value);
            }
        }
        fclose($file);

        return $integers;
    }
}

class FileTypeTxt implements File
{
    public function supports(string $extension): bool
    {
        return $extension === FileType::TXT->value;
    }

    public function read(string $fileName): array
    {
        $integers = [];
        $file = fopen($fileName, 'r');
        while (($line = fgets($file)) !== false) {
            $integers[] = (int) trim($line);
        }
        fclose($file);

        return $integers;
    }
}

final readonly class Task1
{

    /**
     * @param File[] $fileTypesStrategies
     */
    public function __construct(
        private array $fileTypesStrategies
    ) {
    }
    /**
     * @return int[]
     * @throws Exception
     */
    public function getNumbers(string $fileName): array
    {
        if (!file_exists($fileName)) {
            throw new Exception('File not found');
        }

        $fileExtension = $this->getFileExtension($fileName);
        foreach ($this->fileTypesStrategies as $fileTypesStrategy) {
            if ($fileTypesStrategy->supports($fileExtension)) {
                return $fileTypesStrategy->read($fileName);
            }
        }

        throw new Exception('File type not supported');
    }

    private function getFileExtension(string $fileName): string
    {
        return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    }
}

$task1 = new Task1([
    new FileTypeCsv(),
    new FileTypeTxt(),
]);

$integers1 = $task1->getNumbers('file1.txt');

$integers2 = $task1->getNumbers('file2.csv');

$allIntegers = array_merge($integers1, $integers2);

// Display elements of file1 folowed by elements from file2
echo implode(', ', $allIntegers);


// Display intersection of the elements of both files
sort($allIntegers);
echo "\n";
echo sprintf('In ascending order: %s', implode(', ', $allIntegers));

// Display intersection of the elements of both files
sort($allIntegers);
echo "\n";
echo sprintf('Intersection: %s', implode(', ', array_unique(array_intersect($integers1, $integers2))));