<?php declare(strict_types = 1);

namespace App\ReportGenerator;

use App\Crawler\Link;
use App\Helpers\Collection;

/**
 * Class HtmlReportGenerator
 * @package App\ReportGenerator
 */
class HtmlReportGenerator extends AbstractReportGenerator
{
    /**
     * @param Collection $data
     * @return string
     */
    protected function makeContent(Collection $data) : string
    {
        $table = $this->generateTable($data);

        $pageBuilder = new HtmlPageBuilder();
        $pageBuilder->setBody($table);
        return $pageBuilder->build();
    }

    /**
     * @param Collection $data
     * @return string
     */
    private function generateTable(Collection $data) : string
    {
        $tableBuilder = new HtmlTableBuilder();

        $tableBuilder->setHeader($this->generateHeaderTable());

        $htmlRows = $data->map(function (Link $link) {
            return $this->linkToTableRow($link);
        })->implode();

        $tableBuilder->setBody($htmlRows);


        return $tableBuilder->build();
    }

    /**
     * @return string
     */
    private function generateHeaderTable() : string
    {
        return '<tr>
                    <td>url</td>
                    <td>count of img</td>
                    <td>duration page process</td>
                </tr>';
    }

    /**
     * @param Link $link
     * @return string
     */
    private function linkToTableRow(Link $link) : string
    {
        return "<tr>
                    <td>{$link->getUrl()}</td>
                    <td>{$link->getCountImages()}</td>
                    <td>{$link->getWorkTime()}</td>
                </tr>";
    }

    /**
     * @return string
     */
    protected function saveDir() : string
    {
        return __DIR__ . '/../../reports';
    }
}
