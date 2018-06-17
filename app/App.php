<?php declare( strict_types = 1 );

namespace App;

use App\Crawler\CrawlerInterface;
use App\Crawler\Link;
use App\Exception\CrawlerDomainInvalidException;
use App\Input\ConsoleInputInterface;
use App\ReportGenerator\AbstractReportGenerator;
use App\Validation\SiteValidator;

/**
 * Class App
 * @package App
 */
class App
{
    /**
     * @var CrawlerInterface
     */
    private $crawler;

    /**
     * @var AbstractReportGenerator
     */
    private $reportGenerator;

    /**
     * App constructor.
     * @param CrawlerInterface $crawler
     * @param AbstractReportGenerator $reportGenerator
     */
    public function __construct (CrawlerInterface $crawler, AbstractReportGenerator $reportGenerator)
    {
        $this->crawler         = $crawler;
        $this->reportGenerator = $reportGenerator;
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @throws \Exception
     */
    public function handle (ConsoleInputInterface $consoleInput)
    {
        $targetDomain = $consoleInput->getArguments()->offsetGet(1);

        $this->validationUrl($targetDomain);

        $this->crawler->init($targetDomain)->run();
        $crawlerResult = $this->crawler->getResult()->sortBy(function(Link $prev, Link $next) {
            return $prev->getCountImages() < $next->getCountImages();
        });

        $this->reportGenerator->generate(
            (new Link($targetDomain))->getHost(),
            $crawlerResult
        );
    }

    /**
     * @param string $url
     * @throws CrawlerDomainInvalidException
     */
    private function validationUrl (?string $url) : void
    {
        $siteValidator = new SiteValidator($url);

        if (! $siteValidator->isValid()) {
            throw new CrawlerDomainInvalidException($url);
        }
    }
}