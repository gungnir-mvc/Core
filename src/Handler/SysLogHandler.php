<?php
namespace Gungnir\Log\Handler;
use Gungnir\Log\LogLevel;

/**
 * Class SysLogHandler
 * @package Gungnir\Log\Handler
 */
class SysLogHandler implements LogHandlerInterface
{
    /** @var String */
    private $destination = null;

    /** @var Int */
    private $delay = null;

    /** @var Int */
    private $facility = null;

    /**
     * SysLogHandler constructor.
     * @param String $destination
     */
    public function __construct(String $destination, Int $delay = LOG_NDELAY, Int $facility = LOG_USER)
    {
        $this->setDestination($destination);
        $this->setDelay($delay);
        $this->setFacility($facility);
    }

    /**
     * @return String
     */
    public function getDestination(): String
    {
        return $this->destination;
    }

    /**
     * @param String $destination
     * @return SysLogHandler
     */
    public function setDestination(String $destination): SysLogHandler
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return Int
     */
    public function getDelay(): Int
    {
        return $this->delay;
    }

    /**
     * @param Int $delay
     * @return SysLogHandler
     */
    public function setDelay(Int $delay): SysLogHandler
    {
        $this->delay = $delay;
        return $this;
    }

    /**
     * @return Int
     */
    public function getFacility(): Int
    {
        return $this->facility;
    }

    /**
     * @param Int $facility
     * @return SysLogHandler
     */
    public function setFacility(Int $facility): SysLogHandler
    {
        $this->facility = $facility;
        return $this;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message)
    {
        openlog($this->getDestination(), $this->getDelay(), $this->getFacility());
        syslog($this->getSysLogLevel($level), $message);
        closelog();
    }

    /**
     * Translates PSR log levels to syslog levels.
     * Any unknown log level defaults to debug.
     *
     * @param $level
     * @return int
     */
    private function getSysLogLevel($level)
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                return LOG_EMERG;
            case LogLevel::ALERT:
                return LOG_ALERT;
            case LogLevel::CRITICAL:
                return LOG_CRIT;
            case LogLevel::ERROR:
                return LOG_ERR;
            case LogLevel::WARNING:
                return LOG_WARNING;
            case LogLevel::NOTICE:
                return LOG_NOTICE;
            case LogLevel::INFO:
                return LOG_INFO;
            default:
                return LOG_DEBUG;
        }
    }
}