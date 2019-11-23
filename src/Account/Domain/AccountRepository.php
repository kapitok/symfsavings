<?php

declare(strict_types=1);

namespace App\Account\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

interface AccountRepository
{
    public function createNew(Account $account): Account;
    public function save(Account $account): Account;
    public function getById($id): ?EventSourcedAggregateRoot;
}
