<?php declare( strict_types = 1 );

namespace Tests;

use App\Helpers\Collection;
use App\ReportGenerator\ReportSaverInterface;
use App\ReportGenerator\HtmlReportGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class HtmlReportGeneratorTest
 * @package Tests
 */
class HtmlReportGeneratorTest extends TestCase
{
    /**
     * @return void
     */
    public function testGenerate () : void
    {
        $mockFileSaver = $this->createMock(ReportSaverInterface::class);
        $mockFileSaver->expects(self::once())->method('save');

        $generator = new HtmlReportGenerator($mockFileSaver);
        $generator->generate('reportName', new Collection());
    }

    /**
     * @return void
     */
    public function testMakeContent () : void
    {
        $mockFileSaver = $this->createMock(ReportSaverInterface::class);
        $mockFileSaver->expects(self::never())->method('save');

        $generator   = new HtmlReportGenerator($mockFileSaver);
        $reflection  = new ReflectionClass($generator);
        $makeContent = $reflection->getMethod('makeContent');
        $makeContent->setAccessible(true);

        $generatedContent = $makeContent->invokeArgs($generator, [
            new Collection()
        ]);

        self::assertNotEmpty($generatedContent);
    }
}
