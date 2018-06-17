<?php declare( strict_types = 1 );

namespace App\Helpers;


/**
 * Class Timer
 * @package App\Helpers
 */
/**
 * Class Timer
 * @package App\Helpers
 */
class Timer
{
    /**
     * @var float
     */
    private $startTime;

    /**
     * @var float
     */
    private $endTime;

    /**
     * @return Timer
     */
    public function start () : self
    {
        $this->startTime = microtime(true);

        return $this;
    }

    /**
     * @return Timer
     */
    public function stop () : self
    {
        $this->endTime = microtime(true);

        return $this;
    }

    /**
     * @return float
     */
    public function diff () : float
    {
        return $this->endTime - $this->startTime;
    }

    /**
     * @return Timer
     */
    public static function make () : self
    {
        return new self;
    }

    /**
     * @param callable $callback
     * @return Timer
     */
    public static function track (callable $callback) : Timer
    {
        $self = self::make();

        $self->start();
        $callback();
        $self->stop();

        return $self;
    }
}