<?php declare(strict_types = 1);

namespace App\ReportGenerator;

/**
 * Class HtmlTableBuilder
 * @package App\ReportGenerator
 */
/**
 * Class HtmlTableBuilder
 * @package App\ReportGenerator
 */
class HtmlTableBuilder
{
    /**
     * @var string
     */
    private $html = '';

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $body;

    /**
     * @return void
     */
    private function openTag() : void
    {
        $this->html .= '<table>';
    }

    /**
     * @return void
     */
    private function closeTag() : void
    {
        $this->html .= '</table>';
    }

    /**
     * @param string $header
     * @return HtmlTableBuilder
     */
    public function setHeader(string $header) : HtmlTableBuilder
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @param string $body
     * @return HtmlTableBuilder
     */
    public function setBody(string $body) : HtmlTableBuilder
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return void
     */
    public function buildHeader() : void
    {
        $this->html .= $this->header;
    }

    /**
     * @return void
     */
    public function buildBody() : void
    {
        $this->html .= $this->body;
    }

    /**
     * @return string
     */
    public function build() : string
    {
        $this->openTag();
        $this->buildHeader();
        $this->buildBody();
        $this->closeTag();

        return $this->html;
    }
}
