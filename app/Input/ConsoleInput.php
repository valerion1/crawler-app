<?php declare( strict_types = 1 );

namespace App\Input;

use App\Helpers\Collection;

/**
 * Class ConsoleInput
 * @package Thread
 */
class ConsoleInput implements ConsoleInputInterface
{
    /**
     * @var Collection
     */
    private $arguments;

    /**
     * ConsoleInput constructor.
     * @param array $arguments
     */
    public function __construct (array $arguments)
    {
        $this->arguments = new Collection($arguments);
    }

    /**
     * @return ConsoleInput
     */
    public static function createFromGlobals () : ConsoleInput
    {
        return new self($_SERVER['argv']);
    }

    /**
     * @return Collection
     */
    public function getArguments () : Collection
    {
        return $this->arguments;
    }
}