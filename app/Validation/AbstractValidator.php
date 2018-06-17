<?php declare( strict_types = 1 );

namespace App\Validation;

/**
 * Class AbstractValidator
 * @package Thread
 */
abstract class AbstractValidator
{
    /**
     * @var string
     */
    private $subject;

    /**
     * AbstractValidator constructor.
     * @param string $subject
     */
    public function __construct (?string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return bool
     */
    public function isValid () : bool
    {
        return $this->subject !== null && preg_match($this->pattern(), $this->subject) === 1;
    }

    /**
     * @return string
     */
    abstract public function pattern() : string;
}