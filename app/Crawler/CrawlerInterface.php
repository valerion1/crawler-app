<?php declare(strict_types = 1);

namespace App\Crawler;

use App\Helpers\Collection;

/**
 * Interface CrawlerInterface
 * @package App\Crawler
 */
interface CrawlerInterface
{
    /**
     * Initialization first site url
     *
     * @param string $targetDomain
     * @return self
     */
    public function init(string $targetDomain) : CrawlerInterface;

    /**
     * Run crawler
     *
     * @return void
     */
    public function run() : void;

    /**
     * Get result work of crawler
     *
     * @return Collection
     */
    public function getResult() : Collection;
}
