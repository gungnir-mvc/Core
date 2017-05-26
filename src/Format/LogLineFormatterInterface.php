<?php
namespace Gungnir\Log\Format;

interface LogLineFormatterInterface
{

    /**
     * Formats a message to output in logs as a line
     *
     * @param String $message
     * @param array $context
     *
     * @return String
     */
    public function format($level, String $message, array $context = array()) : String;
}