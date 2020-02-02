<?php

namespace App\Account\Domain\ValueObject;

/**
 * Class Currency
 *
 * @package App\Account\Domain\ValueObject
 */
class Currency
{
    /**
     * @var string
     */
    private $currencyCode;

    public function __construct(string $currencyCode = 'pln')
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function __toString()
    {
        return $this->currencyCode;
    }
}
