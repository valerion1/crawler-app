<?php declare( strict_types = 1 );

namespace App\Crawler;

/**
 * Class Link
 * @package App\Crawler
 */
class Link
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $countImages;

    /**
     * @var float
     */
    private $workTime;

    /**
     * Site constructor.
     * @param string $url
     */
    public function __construct (string $url)
    {
        $this->url = $url;
        $this->parse();
    }

    /**
     * @return void
     */
    private function parse () : void
    {
        $parsedUrl = parse_url($this->url);

        $this->scheme = $parsedUrl['scheme'];
        $this->path   = $parsedUrl['path'];
        $this->host   = $parsedUrl['host'];
    }

    /**
     * @return int
     */
    public function getCountImages () : int
    {
        return $this->countImages;
    }

    /**
     * @param int $countImages
     * @return Link
     */
    public function setCountImages (int $countImages) : Link
    {
        $this->countImages = $countImages;

        return $this;
    }

    /**
     * @return float
     */
    public function getWorkTime () : float
    {
        return $this->workTime;
    }

    /**
     * @param float $workTime
     * @return Link
     */
    public function setWorkTime (float $workTime) : Link
    {
        $this->workTime = $workTime;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasCountImages () : bool
    {
        return $this->countImages !== null;
    }

    /**
     * @return string
     */
    public function getUrl () : string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getScheme () : string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getHost () : string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getFullHost () : string
    {
        return $this->scheme . '://' . $this->host;
    }

    /**
     * @return string
     */
    public function getPath () : string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function __toString () : string
    {
        return $this->url;
    }
}