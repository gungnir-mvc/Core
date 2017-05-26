<?php
namespace Application\Test\Gungnir\Log\Format;

use Gungnir\Log\Format\DefaultLogLineFormatter;

class DefaultLogLineFormatterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itFormatsALogLineCorrectly()
    {
        $formatter = new DefaultLogLineFormatter();
        $time = time();
        $level = "INFO";
        $expected = "$time $level This is a log about a blue dog" . PHP_EOL;
        $message = "{{time}} {{level}} This is a log about a {{color}} {{animal}}";
        $context = [
	    'level' => $level,
	    'time' => $time,
            'color' => 'blue',
            'animal' => 'dog'
        ];

        $actual = $formatter->format($level, $message, $context);

        $this->assertEquals($expected, $actual);
    }

}
