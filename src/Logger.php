<?php
namespace Gungnir\Log;

use Gungnir\Log\Format\LogLineFormatterInterface;
use Gungnir\Log\Handler\LogHandlerInterface;
use Gungnir\Log\Handler\NullLogHandler;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    /** @var LogHandlerInterface */
    private $logHandler = null;

    /** @var LogLineFormatterInterface */
    private $logLineFormatter = null;

    /**
     * @return LogHandlerInterface
     */
    public function getLogHandler(): LogHandlerInterface
    {
        if (empty($this->logHandler)) {
            $this->setLogHandler(new NullLogHandler());
        }
        return $this->logHandler;
    }

    /**
     * @param LogHandlerInterface $logHandler
     * @return Logger
     */
    public function setLogHandler(LogHandlerInterface $logHandler): Logger
    {
        $this->logHandler = $logHandler;
        return $this;
    }

    /**
     * @return LogLineFormatterInterface
     */
    public function getLogLineFormatter(): LogLineFormatterInterface
    {
        return $this->logLineFormatter;
    }

    /**
     * @param LogLineFormatterInterface $logLineFormatter
     * @return Logger
     */
    public function setLogLineFormatter(LogLineFormatterInterface $logLineFormatter): Logger
    {
        $this->logLineFormatter = $logLineFormatter;
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
    public function log($level, $message, array $context = array())
    {
        $message = $this->getLogLineFormatter()->format($level, $message, $context);
        $this->getLogHandler()->log($level, $message);
    }

}