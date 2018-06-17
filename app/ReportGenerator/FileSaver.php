<?php declare( strict_types = 1 );

namespace App\ReportGenerator;

use App\Exception\FailedSaveReportFileException;

/**
 * Class FileSaver
 * @package App\ReportGenerator
 */
class FileSaver implements ReportSaverInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @throws FailedSaveReportFileException
     */
    public function save (string $filename, string $content) : void
    {
        $saveResult = file_put_contents($filename, $content);

        if($saveResult === false) {
            throw new FailedSaveReportFileException($filename);
        }
    }
}