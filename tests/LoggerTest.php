<?php
namespace Application\Test\Gungnir\Log;

use Gungnir\Log\Format\LogLineFormatterInterface;
use Gungnir\Log\Handler\LogHandlerInterface;
use Gungnir\Log\Logger;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itCanLog()
    {
        $mockLogLineFormatter = $this->getMockBuilder(LogLineFormatterInterface::class)
            ->setMethods(['format'])
            ->getMock();

        $mockLogLineFormatter->expects($this->atLeastOnce())
            ->method('format');

        $mockLogHandler = $this->getMockBuilder(LogHandlerInterface::class)
            ->setMethods(['log'])
            ->getMock();

        $mockLogHandler->expects($this->atLeastOnce())
            ->method('log');

        /**
         * @var LogHandlerInterface $mockLogHandler
         * @var LogLineFormatterInterface $mockLogLineFormatter
         */

        $logger = new Logger();
        $logger->setLogHandler($mockLogHandler);
        $logger->setLogLineFormatter($mockLogLineFormatter);
        $logger->info('This is an info log entry');
    }
}