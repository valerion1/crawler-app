<?php declare( strict_types = 1 );

namespace App\Exception;

use Exception;

/**
 * Class CrawlerDomainInvalidException
 * @package App\Exception
 */
class CrawlerDomainInvalidException extends Exception
{
    /**
     * CrawlerDomainInvalidException constructor.
     * @param null|string $subject
     */
    public function __construct (?string $subject)
    {
        parent::__construct("Passed domain \"$subject\" is invalid!");
    }
}