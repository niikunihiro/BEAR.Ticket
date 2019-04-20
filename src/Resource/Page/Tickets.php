<?php
namespace MyVendor\Ticket\Resource\Page;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;
use Ray\CakeDbModule\DatabaseInject;

/**
 * @Cacheable(expirySecond=30)
 */
class Tickets extends ResourceObject
{
    use DatabaseInject;

    /**
     * @param string $id
     *
     * @return ResourceObject
     */
    public function onGet(string $id) : ResourceObject
    {
        $this->body = $this->db->newQuery()->select('*')->from('ticket')
            ->where(['id' => $id])
            ->execute()
            ->fetch('assoc');

        return $this;
    }
}
