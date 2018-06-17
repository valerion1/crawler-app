<?php declare( strict_types = 1 );

namespace App\Validation;

/**
 * Class SiteValidator
 * @package Thread
 */
class SiteValidator extends AbstractValidator
{
    /**
     * @return string
     */
    public function pattern () : string
    {
        return '%^(?:http(s)?://)+[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!$&\'\(\)\*\+,;=.]+$%';
    }
}