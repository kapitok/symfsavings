<?php
declare(strict_types=1);

namespace App\Account\Infrastructure;

use App\Account\Domain\Account;
use App\Account\Domain\AccountRepository;
use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class AccountEventStoreRepository extends EventSourcingRepository implements AccountRepository
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

        parent::__construct(
            $eventStore,
            $eventBus,
            Account::class,
            new NamedConstructorAggregateFactory()
        );
    }

    public function load($id): AggregateRoot
    {
        return parent::load($id);
    }

    public function save(AggregateRoot $aggregate): void
    {
        parent::save($aggregate);
    }
}
