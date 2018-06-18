<?php declare(strict_types = 1);

namespace App\Exception;

use Exception;

/**
 * Class FailedSaveReportFileException
 * @package App\Exception
 */
class FailedSaveReportFileException extends Exception
{
    /**
     * FailedSaveReportFileException constructor.
     * @param string $savePath
     */
    public function __construct(string $savePath)
    {
        parent::__construct("Failed to save report this file: \"{$savePath}\"");
    }
}
