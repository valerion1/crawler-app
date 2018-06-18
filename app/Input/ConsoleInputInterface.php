<?php declare(strict_types = 1);

namespace App\Input;

use App\Helpers\Collection;

/**
 * Interface ConsoleInputInterface
 * @package App
 */
interface ConsoleInputInterface
{
    /**
     * @return Collection
     */
    public function getArguments() : Collection;
}
