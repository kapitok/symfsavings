<?php
declare(strict_types=1);

namespace App\Account\Infrastructure;

use App\Account\Domain\Account;
use App\Account\Domain\AccountRepository;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Repository\AggregateNotFoundException;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class MongoDbAccountRepository implements AccountRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;
    /**
     * @var EventBus
     */
    private $eventBus;
    /**
     * @var AggregateFactory
     */
    private $aggregateFactory;

    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        $this->eventStore = $eventStore;
        $this->eventBus = $eventBus;
        $this->aggregateFactory = new NamedConstructorAggregateFactory();
    }

    public function createNew(Account $account): Account
    {
        $eventStream = $account->getUncommittedEvents();

        $this->eventStore->append($account->getAggregateRootId(), $eventStream);
        $this->eventBus->publish($eventStream);

        return $account;
    }

    public function save(Account $account): Account
    {
        $eventStream = $account->getUncommittedEvents();

        $this->eventStore->append($account->getAggregateRootId(), $eventStream);
        $this->eventBus->publish($eventStream);

        return $account;
    }

    /**
     * @param $id
     * @return Account|EventSourcedAggregateRoot|null
     */
    public function getById($id): ?EventSourcedAggregateRoot
    {
        try {
            $domainEventStream = $this->eventStore->load($id);

            return $this->aggregateFactory->create(Account::class, $domainEventStream);
        } catch (EventStreamNotFoundException $e) {
            throw AggregateNotFoundException::create($id, $e);
        }
    }
}
