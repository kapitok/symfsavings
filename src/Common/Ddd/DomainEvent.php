<?php

namespace App\Common\Ddd;

interface DomainEvent
{
    public function eventId(): UUID;
}

