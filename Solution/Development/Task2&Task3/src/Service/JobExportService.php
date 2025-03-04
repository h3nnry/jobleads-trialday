<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\JobExportFormat;
use App\Exception\JobExportFailure;
use App\JobExportStrategies\ExportStrategyInterface;
use App\Repository\JobRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Psr\Cache\InvalidArgumentException;

readonly class JobExportService implements JobExportServiceInterface
{
    public const JOB_EXPORT_CACHE_LOCK_KEY = 'JOB_EXPORT_CACHE_LOCK';
    private const JOB_EXPORT_KEY_EXPIRATION_TIME = 300;
    private const EXPORT_FILE_PATH = 'var' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
    private const EXPORT_FILE_NAME = 'jobs';

    /**
     * @param ExportStrategyInterface[] $exportStrategies
     */
    public function __construct(
        private iterable $exportStrategies,
        private JobRepository $jobRepository,
        private CacheInterface $cache,
        private Filesystem $filesystem,
    ) {
    }

    /**
     * Return file path
     * @throws JobExportFailure
     * @throws InvalidArgumentException
     */
    public function export(JobExportFormat $jobExportFormat): string
    {
        if ($this->cache->hasItem(self::JOB_EXPORT_CACHE_LOCK_KEY) === true) {
            throw new JobExportFailure('The export process is already running.');
        }

        $this->cache->get(self::JOB_EXPORT_CACHE_LOCK_KEY, function (ItemInterface $item): bool {
            $item->expiresAfter(self::JOB_EXPORT_KEY_EXPIRATION_TIME);
            return true;
        });

        if (!$this->filesystem->exists(self::EXPORT_FILE_PATH)) {
            $this->filesystem->mkdir(self::EXPORT_FILE_PATH);
        }

        foreach ($this->exportStrategies as $strategy) {
            if ($strategy->supports($jobExportFormat->value)) {
                $file = sprintf('%s%s.%s', self::EXPORT_FILE_PATH, self::EXPORT_FILE_NAME, $strategy->getFileExtension());
                $strategy->export($this->jobRepository->iterateOverAllJobs(), $file);
                $this->cache->delete(self::JOB_EXPORT_CACHE_LOCK_KEY);

                return $file;
            }
        }

        throw  new JobExportFailure(sprintf('Invalid format. No strategy available for: %s', $jobExportFormat->value));
    }
}