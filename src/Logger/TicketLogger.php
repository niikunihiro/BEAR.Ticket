<?php
namespace MyVendor\Ticket\Logger;

use BEAR\AppMeta\AbstractAppMeta;

class TicketLogger implements LoggerInterface
{
    private $logFile;

    public function __construct(AbstractAppMeta $meta)
    {
        $this->logFile = $meta->logDir . '/weekday.log';
    }

    public function log(string $message) : void
    {
        \error_log($message . PHP_EOL, 3, $this->logFile);
    }
}
