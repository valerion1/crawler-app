<?php declare( strict_types = 1 );

namespace App\Crawler;

use App\Exception\UnableToLoadPageException;
use App\Helpers\Collection;
use App\Helpers\Timer;

/**
 * Class Crawler
 * @package App\Crawler
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var Link
     */
    private $initialLink;

    /**
     * @var Collection
     */
    private $unhandledLinks;

    /**
     * @var Collection
     */
    private $handledLinks;

    /**
     * Crawler constructor.
     * @param string $targetDomain
     */
    public function __construct (string $targetDomain = null)
    {
        if ($targetDomain === null) {
            $this->unhandledLinks = new Collection();
            $this->handledLinks   = new Collection();
        }
        else {
            $this->init($targetDomain);
        }
    }

    /**
     * @param string $targetDomain
     * @return Crawler
     */
    public function init (string $targetDomain) : self
    {
        $normalizedDomain  = $this->normalizeUrl($targetDomain);
        $this->initialLink = new Link($normalizedDomain);

        $this->unhandledLinks = new Collection([$this->initialLink]);
        $this->handledLinks   = new Collection();

        return $this;
    }

    /**
     * @return void
     * @throws UnableToLoadPageException
     */
    public function run () : void
    {
        while ($this->unhandledLinks->isNotEmpty()) {
            try {
                $this->handleLink($this->unhandledLinks->shift());
            } catch (UnableToLoadPageException $loadPageException) {
                echo PHP_EOL . $loadPageException->getMessage() . PHP_EOL;
            }
        }
    }

    /**
     * @param Link $link
     * @throws UnableToLoadPageException
     */
    private function handleLink (Link $link) : void
    {
        $timer       = Timer::make()->start();
        $pageContent = $this->getPage($link->getUrl());
        $imageCount  = substr_count($pageContent, '<img');
        $timer->stop();

        $link->setCountImages($imageCount);
        $link->setWorkTime($timer->diff());

        $this->handledLinks->push($link);

        $unhandledLinks = $this->retrieveLinks($link, $pageContent);
        $this->appendToUnhandled($unhandledLinks);
    }

    /**
     * @param string $url
     * @return string
     * @throws UnableToLoadPageException
     */
    private function getPage (string $url) : string
    {
        $pageContent = @file_get_contents($url);

        if ($pageContent === false) {
            throw new UnableToLoadPageException($url);
        }

        return $pageContent;
    }

    /**
     * @param Link $link
     * @param string $content
     * @return array
     */
    private function retrieveLinks (Link $link, string $content) : array
    {
        // . - in regex any character
        $preparedHost = str_replace('.', '\.', $link->getHost());
        preg_match_all(
            "#<a.*href=[\"'](http[s]?://{$preparedHost}/?[^\"']+|[/]+[^\"']+)[\"']#U",
            $content,
            $links
        );

        return $links[1];
    }

    /**
     * @param array $links
     */
    private function appendToUnhandled (array $links) : void
    {
        foreach ($links as $url) {
            $normalizedUrl = $this->normalizeUrl($url);

            if (! $this->handledLinks->contains($normalizedUrl)) {
                $this->unhandledLinks->push(new Link($normalizedUrl));
            }
        }

        $this->unhandledLinks->unique();
    }

    /**
     * @param string $url
     * @return string
     */
    private function normalizeUrl (string $url) : string
    {
        return $url[0] === '/' ? $this->initialLink->getFullHost() . $url : $url;
    }

    /**
     * @return Collection
     */
    public function getResult () : Collection
    {
        return $this->handledLinks;
    }
}