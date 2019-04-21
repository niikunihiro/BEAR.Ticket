<?php
namespace MyVendor\Ticket\Resource\Page;

use BEAR\Resource\ResourceObject;

class TicketCreate extends ResourceObject
{
    public function onGet()
    {
        return $this;
    }
}
