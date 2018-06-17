<?php declare( strict_types = 1 );

namespace Tests;

use App\Crawler\Crawler;
use App\Crawler\Link;
use App\Exception\UnableToLoadPageException;
use App\Helpers\Collection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class CrawlerTest
 * @package Tests
 */
class CrawlerTest extends TestCase
{
    /**
     * Domain for tests
     */
    const TEST_DOMAIN = 'http://example.com';


    /**
     * @return void
     */
    public function testCreate () : void
    {
        $crawler    = new Crawler();
        $reflection = new ReflectionClass($crawler);

        $unhandledLinks = $reflection->getProperty('unhandledLinks');
        $unhandledLinks->setAccessible(true);

        self::assertEquals(
            $unhandledLinks->getValue($crawler),
            new Collection()
        );

        $handledLinks = $reflection->getProperty('handledLinks');
        $handledLinks->setAccessible(true);

        self::assertEquals(
            $handledLinks->getValue($crawler),
            new Collection()
        );
    }

    /**
     * @return void
     */
    public function testInit () : void
    {
        $crawler    = new Crawler(self::TEST_DOMAIN);
        $reflection = new ReflectionClass($crawler);

        $initialLink = $reflection->getProperty('initialLink');
        $initialLink->setAccessible(true);

        self::assertEquals(
            $initialLink->getValue($crawler),
            new Link(self::TEST_DOMAIN)
        );

        $unhandledLinks = $reflection->getProperty('unhandledLinks');
        $unhandledLinks->setAccessible(true);

        self::assertEquals(
            $unhandledLinks->getValue($crawler),
            new Collection([new Link(self::TEST_DOMAIN)])
        );
    }

    /**
     * @return void
     */
    public function testRun () : void
    {
        $crawler = new Crawler(self::TEST_DOMAIN);
        $crawler->run();

        $reflection = new ReflectionClass($crawler);

        $handledLinks = $reflection->getProperty('handledLinks');
        $handledLinks->setAccessible(true);

        /** @var Collection $handledLinksCollection */
        $handledLinksCollection = $handledLinks->getValue($crawler);

        self::assertTrue($handledLinksCollection->isNotEmpty());
    }

    /**
     * @return void
     */
    public function testHandleLink () : void
    {
        $crawler    = new Crawler(self::TEST_DOMAIN);
        $reflection = new ReflectionClass($crawler);
        $handleLink = $reflection->getMethod('handleLink');
        $handleLink->setAccessible(true);

        $handleLink->invokeArgs($crawler, [new Link(self::TEST_DOMAIN)]);

        $handledLinks = $reflection->getProperty('handledLinks');
        $handledLinks->setAccessible(true);

        /** @var Collection $handledLinksCollection */
        $handledLinksCollection = $handledLinks->getValue($crawler);

        self::assertTrue($handledLinksCollection->isNotEmpty());
    }

    /**
     * @return void
     */
    public function testGetPage () : void
    {
        $crawler    = new Crawler(self::TEST_DOMAIN);
        $reflection = new ReflectionClass($crawler);
        $getPage    = $reflection->getMethod('getPage');
        $getPage->setAccessible(true);

        $loadedPage = $getPage->invokeArgs($crawler, [self::TEST_DOMAIN]);

        self::assertNotEmpty($loadedPage);

        $this->expectException(UnableToLoadPageException::class);

        $getPage->invokeArgs($crawler, [self::TEST_DOMAIN . '/1']);
    }

    /**
     * @return void
     */
    public function testRetrieveLinks () : void
    {
        $crawler       = new Crawler(self::TEST_DOMAIN);
        $reflection    = new ReflectionClass($crawler);
        $retrieveLinks = $reflection->getMethod('retrieveLinks');
        $retrieveLinks->setAccessible(true);

        $links = $retrieveLinks->invokeArgs($crawler, [
            new Link(self::TEST_DOMAIN),
            $this->makeTestableHtml(),
        ]);

        self::assertEquals(\count($links), 2);
    }

    /**
     * @return string
     */
    private function makeTestableHtml () : string
    {
        $link = self::TEST_DOMAIN . '/test';

        return "test<a href=\"{$link}\">test<a href=\"{$link}\">";
    }

    /**
     * @return void
     */
    public function testAppendToUnhandled () : void
    {
        $crawler           = new Crawler(self::TEST_DOMAIN);
        $reflection        = new ReflectionClass($crawler);
        $appendToUnhandled = $reflection->getMethod('appendToUnhandled');
        $appendToUnhandled->setAccessible(true);

        $appendToUnhandled->invokeArgs($crawler, [
            [
                self::TEST_DOMAIN,
                self::TEST_DOMAIN,
            ],
        ]);


        $unhandledLinks = $reflection->getProperty('unhandledLinks');
        $unhandledLinks->setAccessible(true);

        /** @var Collection $unhandledLinksCollection */
        $unhandledLinksCollection = $unhandledLinks->getValue($crawler);

        self::assertTrue($unhandledLinksCollection->isNotEmpty());
        self::assertEquals($unhandledLinksCollection->count(), 1);
    }

    /**
     * @return void
     */
    public function testNormalizeUrl () : void
    {
        $crawler      = new Crawler(self::TEST_DOMAIN);
        $reflection   = new ReflectionClass($crawler);
        $normalizeUrl = $reflection->getMethod('normalizeUrl');
        $normalizeUrl->setAccessible(true);

        $normalizedUrl = $normalizeUrl->invokeArgs($crawler, [
            '/path',
        ]);

        self::assertEquals($normalizedUrl, self::TEST_DOMAIN . '/path');
    }

    /**
     * @return void
     */
    public function testGetResult () : void
    {
        $crawler = new Crawler(self::TEST_DOMAIN);

        self::assertTrue($crawler->getResult()->isEmpty());
    }
}
