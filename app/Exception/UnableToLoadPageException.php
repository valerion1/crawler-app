<?php declare( strict_types = 1 );

namespace App\Exception;


use Exception;

/**
 * Class UnableToLoadPageException
 * @package App\Exception
 */
class UnableToLoadPageException extends Exception
{
    /**
     * UnableToLoadPageException constructor.
     * @param string $url
     */
    public function __construct (string $url)
    {
        parent::__construct("Unable to load this page: \"$url\"");
    }
}