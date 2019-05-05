<?php
namespace MyVendor\Ticket\Resource\App\Api;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Purge;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\Annotation\Transactional;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Di\Di\Named;
use Ray\IdentityValueModule\NowInterface;
use Ray\IdentityValueModule\UuidInterface;
use Ray\Query\Annotation\AliasQuery;

class Tickets extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    /** @var callable */
    private $createTicket;
    /** @var NowInterface */
    private $now;
    /** @var UuidInterface */
    private $uuid;

    /**
     * @Named("createTicket=ticket_insert")
     *
     * Tickets constructor.
     *
     * @param callable      $createTicket
     * @param NowInterface  $now
     * @param UuidInterface $uuid
     */
    public function __construct(callable $createTicket, NowInterface $now, UuidInterface $uuid)
    {
        $this->createTicket = $createTicket;
        $this->now = $now;
        $this->uuid = $uuid;
    }

    /**
     * @JsonSchema(schema="tickets.json")
     *
     * @return ResourceObject
     */
    public function onGet() : ResourceObject
    {
        $tickets = $this->pdo->fetchAll($this->query['ticket_list']);
        $this->body = compact('tickets');

        return $this;
    }

    /**
     * @ReturnCreatedResource
     * @Transactional
     * @Purge(uri="app://self/api/tickets")
     *
     * @param string $title
     * @param string $description
     * @param string $assignee
     *
     * @return ResourceObject
     */
    public function onPost(string $title, string $description = '', string $assignee = '') : ResourceObject
    {
        $id = (string) $this->uuid;
        $time = (string) $this->now;
        ($this->createTicket)([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'assignee' => $assignee,
            'status' => '',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = '/api/ticket?id=' . $id;

        return $this;
    }
}
