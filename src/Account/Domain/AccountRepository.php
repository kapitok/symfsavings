<?php

declare(strict_types=1);

namespace App\Account\Domain;

use Broadway\Domain\AggregateRoot;

/**
 * Interface AccountRepository
 *
 * @package App\Account\Domain
 */
interface AccountRepository
{
    public function save(AggregateRoot $account): void;
    public function load($id): ?AggregateRoot;
}
