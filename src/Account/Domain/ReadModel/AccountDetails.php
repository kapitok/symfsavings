<?php
declare(strict_types=1);

namespace App\Account\Domain\ReadModel;


use App\Account\Domain\ValueObject\Currency;
use App\Common\Shared\AccountId;
use Broadway\ReadModel\SerializableReadModel;

class AccountDetails implements SerializableReadModel
{
    /** @var AccountId */
    protected $accountId;

    /** @var string */
    protected $name;

    /** @var Currency */
    protected $currency;

    /** @var float */
    protected $balance;

    public function __construct(AccountId $accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->accountId;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data): self
    {
        $options = static::resolveOptions($data);

        $account = new self(AccountId::fromString($options['accountId']));

        $account->setName($options['name']);
        $account->setCurrency(new Currency($options['currency']));
        $account->setBalance((float)$options['balance']);

        return $account;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'accountId' => $this->getId(),
            'name' => $this->getName(),
            'currency' => (string) $this->getCurrency(),
            'balance' => $this->getBalance(),
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function resolveOptions(array $options): array
    {
        $default = [
            'accountId' => null,
            'name' => null,
            'currency' => null,
            'balance' => null,
        ];

        return array_merge($default, $options);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}
