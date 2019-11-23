<?php

namespace App\Common\Ddd;

final class Success extends Result
{
    /**
     * @var DomainEvent[]
     */
    protected $events;

    public function __construct(array $events)
    {
        $this->events = array_map(function (DomainEvent $event): DomainEvent {return  $event; }, $events);
    }
}
