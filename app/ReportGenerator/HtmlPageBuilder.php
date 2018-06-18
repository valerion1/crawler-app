<?php declare(strict_types = 1);

namespace App\ReportGenerator;

/**
 * Class HtmlPageBuilder
 * @package App\ReportGenerator
 */
/**
 * Class HtmlPageBuilder
 * @package App\ReportGenerator
 */
class HtmlPageBuilder
{
    /**
     * Default head content
     */
    private const DEFAULT_HEAD_CONTENT = '<meta charset="UTF-8"><title>Report crawler</title>';

    /**
     * @var string
     */
    private $html = '';
    /**
     * @var string
     */
    private $head = '';
    /**
     * @var string
     */
    private $body = '';

    /**
     * @return HtmlPageBuilder
     */
    private function buildHead() : self
    {
        if (empty($this->head)) {
            $this->setHead(self::DEFAULT_HEAD_CONTENT);
        }

        $this->html .= $this->head;

        return $this;
    }

    /**
     * @return self
     */
    private function buildBody() : self
    {
        $this->html .= $this->body;

        return $this;
    }

    /**
     * @return self
     */
    private function buildPage() : self
    {
        $this->buildHead();
        $this->buildBody();

        $this->html = "
            <!doctype html>
            <html lang=\"en\">
                <head>{$this->head}</head>
                <body>{$this->body}</body>
            </html>
        ";

        return $this;
    }

    /**
     * @return string
     */
    public function build() : string
    {
        $this->buildPage();

        return $this->html;
    }

    /**
     * @param string $head
     * @return self
     */
    public function setHead(string $head) : self
    {
        $this->head = $head;

        return $this;
    }

    /**
     * @param string $body
     * @return self
     */
    public function setBody(string $body) : self
    {
        $this->body = $body;

        return $this;
    }
}
