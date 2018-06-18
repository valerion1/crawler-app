<?php declare(strict_types = 1);

namespace App\ReportGenerator;

use App\Exception\FailedSaveReportFileException;
use App\Helpers\Collection;

/**
 * Class AbstractReportGenerator
 * @package App\ReportGenerator
 */
abstract class AbstractReportGenerator
{
    /**
     * Prefix name file, example:
     * {prefix}_12.04.2018.html
     *
     * @var string
     */
    private $filenamePrefix;

    /**
     * @var ReportSaverInterface
     */
    private $fileSaver;

    /**
     * AbstractReportGenerator constructor.
     * @param ReportSaverInterface $fileSaver
     */
    public function __construct(ReportSaverInterface $fileSaver)
    {
        $this->fileSaver = $fileSaver;
    }

    /**
     * @param string $reportName
     * @param Collection $data
     * @return void
     * @throws FailedSaveReportFileException
     */
    public function generate(string $reportName, Collection $data) : void
    {
        $this->filenamePrefix = $reportName;

        $this->save($this->makeContent($data));
    }

    /**
     * @param string $content
     * @throws FailedSaveReportFileException
     */
    final protected function save(string $content) : void
    {
        $this->fileSaver->save($this->savePath(), $content);
    }

    /**
     * @param Collection $data
     * @return string
     */
    abstract protected function makeContent(Collection $data) : string;

    /**
     * @return string
     */
    private function savePath() : string
    {
        return rtrim($this->saveDir(), '/') . '/' . ltrim($this->filename(), '/');
    }

    /**
     * @return string
     */
    abstract protected function saveDir() : string;

    /**
     * @return string
     */
    protected function filename() : string
    {
        return $this->filenamePrefix . '_' . date('d.m.Y') . '.html';
    }
}
