<?php
declare(strict_types=1);

namespace App\Account\Application;

use App\Common\Shared\AccountId;

class WithdrawFundsCommand
{
    /**
     * @var float
     */
    private $amount;

    /**
     * @var AccountId
     */
    private $accountId;

    public function __construct(AccountId $accountId, float $amount)
    {
        $this->amount = $amount;
        $this->accountId = $accountId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return AccountId
     */
    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }
}
