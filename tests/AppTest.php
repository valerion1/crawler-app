<?php declare(strict_types = 1);

namespace Tests;

use App\App;
use App\Crawler\Crawler;
use App\Crawler\CrawlerInterface;
use App\Exception\CrawlerDomainInvalidException;
use App\Helpers\Collection;
use App\Input\ConsoleInputInterface;
use App\ReportGenerator\AbstractReportGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class AppTest
 * @package Tests
 */
class AppTest extends TestCase
{
    /**
     * @return void
     */
    public function testValidateUrl() : void
    {
        $mockCrawler         = $this->createMock(CrawlerInterface::class);
        $mockReportGenerator = $this->createMock(AbstractReportGenerator::class);
        $testApp             = new App($mockCrawler, $mockReportGenerator);

        $appReflection = new ReflectionClass($testApp);
        $method        = $appReflection->getMethod('validationUrl');
        $method->setAccessible(true);


        $this->expectException(CrawlerDomainInvalidException::class);

        $method->invokeArgs($testApp, [null]);
        $method->invokeArgs($testApp, ['example.com']);
    }

    /**
     * @return void
     */
    public function testHandle() : void
    {
        $mockCrawler = $this->getMockBuilder(Crawler::class)->setMethods([
            'appendToUnhandled',
            'init',
            'run',
        ])->getMock();
        $mockCrawler->expects(static::any())->method('appendToUnhandled');
        $mockCrawler->expects(static::once())->method('init')
                    ->with(self::stringContains('http'))
                    ->will(self::returnValue($mockCrawler));
        $mockCrawler->expects(static::once())->method('run');

        $mockReportGenerator = $this->createMock(AbstractReportGenerator::class);
        $mockReportGenerator->expects(static::once())->method('generate');

        $testApp = new App($mockCrawler, $mockReportGenerator);

        $mockConsoleInput = $this->createMock(ConsoleInputInterface::class);
        $mockConsoleInput->method('getArguments')->willReturn(
            new Collection([1 => 'https://example.com'])
        );
        $testApp->handle($mockConsoleInput);
    }
}
