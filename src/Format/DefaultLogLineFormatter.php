<?php
namespace Gungnir\Log\Format;


class DefaultLogLineFormatter implements LogLineFormatterInterface
{

    /**
     * Formats a message to output in logs as a line
     *
     * @param String $message
     * @param array $context
     *
     * @return String
     */
    public function format($level, String $message, array $context = array()): String
    {
        $parameters = [
            "{{time}}" => time(),
            "{{level}}" => strtoupper($level)
        ];

        foreach ($context AS $key => $value) {
            $parameters["{{" . $key . "}}"] = $value;
        }

        return $this->interpolate($message, $parameters) . PHP_EOL;
    }

    /**
     * @param $message
     * @param $parameters
     *
     * @return String
     */
    private function interpolate($message, $parameters) : String
    {
        $message = str_replace(array_keys($parameters), array_values($parameters), $message);
        return str_replace(array_keys($parameters), array_values($parameters), $message);
    }
}