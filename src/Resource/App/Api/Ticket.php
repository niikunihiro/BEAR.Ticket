<?php
namespace MyVendor\Ticket\Resource\App\Api;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\RepositoryModule\Annotation\HttpCache;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Ray\Query\Annotation\AliasQuery;

/**
 * Class Ticket
 * @Cacheable
 * @HttpCache(isPrivate=true, noCache=true)
 */
class Ticket extends ResourceObject
{
    /**
     * @JsonSchema(key="ticket", schema="ticket.json")
     * @AliasQuery("ticket_item_by_id", type="row")
     *
     * @param string $id
     *
     * @return ResourceObject
     */
    public function onGet(string $id) : ResourceObject
    {
        unset($id);

        return $this;
    }
}
