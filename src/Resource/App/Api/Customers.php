<?php
namespace MyVendor\Ticket\Resource\App\Api;

use BEAR\Resource\ResourceObject;
use Koriym\QueryLocator\QueryLocatorInject;
use MyVendor\Ticket\Annotation\TicketLink;
use Ray\AuraSqlModule\AuraSqlInject;

class Customers extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    /**
     * @TicketLink
     */
    public function onGet() : ResourceObject
    {
//        $customers = $this->pdo->fetchAll($this->query['customer_list']);
//        $this->body = compact('customers');

//        $customer = $this->pdo->fetchOne($this->query['customer_list'], ['name' => 'Keith']);
        $customer = [
            'name' => 'Keith',
        ];
        $this->body = compact('customer');

        return $this;
    }
}
