<?php declare( strict_types = 1 );

namespace App\ReportGenerator;

/**
 * Interface FileSaverInterface
 * @package App\ReportGenerator
 */
interface FileSaverInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @return void
     */
    public function save (string $filename, string $content) : void;
}