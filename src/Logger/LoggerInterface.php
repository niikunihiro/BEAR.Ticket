<?php
namespace MyVendor\Ticket\Logger;

interface LoggerInterface
{
    public function log(string $message) : void;
}
