<?php
declare(strict_types=1);

namespace App\Account\Domain;

use App\Common\Ddd\DomainEvent;
use App\Common\Ddd\UUID;
use App\Common\Shared\AccountId;
use Broadway\Serializer\Serializable;

class AccountDeposited implements DomainEvent, Serializable
{
    private $accountId;
    private $when;
    /**
     * @var float
     */
    private $amount;

    private function __construct(AccountId $id, float $amount, \DateTimeImmutable $when)
    {
        $this->accountId = $id;
        $this->when = $when;
        $this->amount = $amount;
    }

    public static function new(AccountId $id, float $amount, \DateTimeImmutable $when): self
    {
        return new self($id, $amount, $when);
    }

    public function eventId(): UUID
    {
        return $this->accountId->getValue();
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new self(new AccountId(new UUID($data['aggregateId'])), $data['amount'], new \DateTimeImmutable());
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'aggregateId' => $this->accountId->__toString(),
            'amount' => $this->amount,
            'when' => $this->when->format('Y-m-d hh:mm'),
        ];
    }

    /**
     * @return AccountId
     */
    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
