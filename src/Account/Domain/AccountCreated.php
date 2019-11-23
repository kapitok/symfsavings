<?php
declare(strict_types=1);

namespace App\Account\Domain;

use App\Account\Domain\ValueObject\Currency;
use App\Common\Ddd\DomainEvent;
use App\Common\Ddd\UUID;
use App\Common\Shared\AccountId;
use Broadway\Serializer\Serializable;

class AccountCreated implements DomainEvent, Serializable
{
    /**
     * @var AccountId
     */
    private $accountId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Currency
     */
    private $currency;
    /**
     * @var \DateTimeImmutable
     */
    private $when;

    private function __construct(AccountId $accountId, string $name, Currency $currency, \DateTimeImmutable $when)
    {
        $this->accountId = $accountId;
        $this->name = $name;
        $this->currency = $currency;
        $this->when = $when;
    }

    public static function new(AccountId $accountId, string $name, Currency $currency, \DateTimeImmutable $when): self
    {
        return new self($accountId, $name, $currency,  $when);
    }

    public function eventId(): UUID
    {
        return UUID::random();
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return self::new(
            new AccountId(new UUID($data['aggregateId'])),
            $data['name'],
            new Currency(),
            new \DateTimeImmutable()
        );
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'aggregateId' => (string) $this->accountId,
            'name' => $this->name,
            'currency' => (string) $this->currency
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
