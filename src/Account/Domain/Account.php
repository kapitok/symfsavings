<?php
declare(strict_types=1);

namespace App\Account\Domain;

use App\Account\Domain\ValueObject\Currency;
use App\Common\Ddd\Result;
use App\Common\Shared\AccountId;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Account extends EventSourcedAggregateRoot
{
    protected $accountId;
    protected $name;
    protected $currency;
    protected $balance;

    private function __construct()
    {
    }

    protected function init(AccountId $accountId, string $name, Currency $currency): self
    {
        $this->accountId = $accountId;
        $this->name = $name;
        $this->currency = $currency;
        $this->balance = 0.0;

        $this->apply(
            AccountCreated::new(
                $this->getAccountId(),
                $this->getName(),
                $this->getCurrency(),
                new \DateTimeImmutable()
            )
        );

        return $this;
    }

    public static function create(AccountId $accountId, string $name, Currency $currency): self
    {
        return (new self())->init($accountId, $name, $currency);
    }

    public static function instantiateForReconstitution(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return  (string) $this->accountId;
    }

    public function addFunds(float $amount): Result
    {
        $this->balance += $amount;

        $this->apply(AccountDeposited::new($this->accountId, $amount, new \DateTimeImmutable()));

        return Result::success();
    }

    public function withdrawFunds(float $amount): Result
    {
        if ($this->balance < $amount) {
            return Result::failure('Balance is lower than amount');
        }

        $this->apply(AccountWithdrew::new($this->accountId, $amount, new \DateTimeImmutable()));

        return Result::success();
    }

    public function applyAccountCreated(AccountCreated $event)
    {
        $this->accountId = $event->getAccountId();
        $this->name = $event->getName();
        $this->currency = $event->getCurrency();
        $this->balance = 0.0;
    }

    public function applyAccountDeposited(AccountDeposited $event)
    {
        $this->balance += $event->getAmount();
    }

    public function applyAccountWithdrew(AccountWithdrew $event)
    {
        $this->balance -= $event->getAmount();
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

    /**
     * @return AccountId
     */
    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }
}
