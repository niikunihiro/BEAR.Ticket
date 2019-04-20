<?php
namespace MyVendor\Ticket\Resource\App;

use BEAR\Resource\ResourceObject;
use MyVendor\Ticket\Logger\LoggerInterface;

class Weekday extends ResourceObject
{
    /** @var LoggerInterface $logger */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onGet(int $year, int $month, int $day) : ResourceObject
    {
        $weekday = \DateTime::createFromFormat('Y-m-d', "$year-$month-$day")->format('D');
        $this->body = [
            'weekday' => $weekday
        ];
        $this->logger->log("$year-$month->$day {$weekday}");

        return $this;
    }
}
