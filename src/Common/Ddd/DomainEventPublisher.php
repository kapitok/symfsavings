<?php
declare(strict_types=1);

namespace App\Common\Ddd;

interface DomainEventPublisher
{
    public function publish(DomainEvent $event): void;
}
