<?php

namespace App\Test\Unit\Service;

use App\Entity\Customer;
use App\Enum\JobExportFormat;
use App\Exception\JobExportFailure;
use App\JobExportStrategies\ExportStrartegyCsv;
use App\JobExportStrategies\ExportStrartegyXml;
use App\JobExportStrategies\ExportStrartegyXmlLimited;
use App\Repository\JobRepository;
use App\Service\JobExportService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Cache\CacheInterface;

class JobExportServiceTest extends TestCase
{
    use ProphecyTrait;

    private JobExportService $jobExportService;

    private JobRepository&MockObject $jobRepository;

    private TraceableAdapter&MockObject $cache;
    private Filesystem&MockObject $filesystem;
    private ExportStrartegyCsv&MockObject $exportStrategyCsv;
    private ExportStrartegyXml&MockObject $exportStrategyXml;
    private ExportStrartegyXmlLimited&MockObject $exportStrategyXmlLimited;

    protected function setUp(): void
    {
        $this->jobRepository = $this->createMock(JobRepository::class);
        $this->cache = $this->createMock(TraceableAdapter::class);
        $this->filesystem = $this->createMock(Filesystem::class);
        $this->exportStrategyCsv = $this->createMock(ExportStrartegyCsv::class);
        $this->exportStrategyXml = $this->createMock(ExportStrartegyXml::class);
        $this->exportStrategyXmlLimited = $this->createMock(ExportStrartegyXmlLimited::class);

        $this->jobExportService = new JobExportService(
            [
                $this->exportStrategyCsv,
                $this->exportStrategyXml,
                $this->exportStrategyXmlLimited
            ],
            $this->jobRepository,
            $this->cache,
            $this->filesystem,
        );
    }

    public function testExportExceptionProcessAlreadyRunning(): void
    {
        $this->cache
            ->expects($this->once())
            ->method('hasItem')
            ->willReturn(true);

        $this->expectException(JobExportFailure::class);
        $this->expectExceptionMessage('The export process is already running.');

        $this->jobExportService->export(JobExportFormat::CSV);
    }

    public function testExportExceptionInvalidStrategy(): void
    {
        $this->cache
            ->expects($this->once())
            ->method('hasItem')
            ->willReturn(false);

        $this->filesystem
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $this->cache
            ->expects($this->once())
            ->method('get');

        $this->expectException(JobExportFailure::class);
        $this->expectExceptionMessage(sprintf('Invalid format. No strategy available for: %s', JobExportFormat::CSV->value));

        $jobExportService = new JobExportService(
            [],
            $this->jobRepository,
            $this->cache,
            $this->filesystem,
        );
        $jobExportService->export(JobExportFormat::CSV);
    }


    public function testExportSuccess(): void
    {
        $this->cache
            ->expects($this->once())
            ->method('hasItem')
            ->willReturn(false);

        $this->filesystem
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $this->cache
            ->expects($this->once())
            ->method('get');

        $this->exportStrategyCsv
            ->expects($this->once())
            ->method('supports')
            ->willReturn(true);

        $this->exportStrategyCsv
            ->expects($this->once())
            ->method('export');

        $this->exportStrategyCsv
            ->expects($this->once())
            ->method('getFileExtension')
            ->willReturn(JobExportFormat::CSV->value);

        $result = $this->jobExportService->export(JobExportFormat::CSV);

        $this->assertSame($result, 'var/data/jobs.csv');
    }
}
