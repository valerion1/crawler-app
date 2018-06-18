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
     * @return static
     */
    public function init(string $targetDomain);

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
