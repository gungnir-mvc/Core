<?php
namespace Gungnir\Log\Handler;

interface LogHandlerInterface
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     *
     * @return void
     */
    public function log($level, $message);
}