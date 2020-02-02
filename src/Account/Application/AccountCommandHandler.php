<?php
declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Domain\Account;
use App\Account\Domain\AccountRepository;
use App\Account\Domain\ValueObject\Currency;
use App\Common\Ddd\Result;
use App\Common\Shared\AccountId;
use Broadway\CommandHandling\SimpleCommandHandler;

class AccountCommandHandler extends SimpleCommandHandler
{
    /** @var AccountRepository */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleCreateNewAccountCommand(CreateNewAccountCommand $command): void
    {
        $this->repository->save(Account::create(
            new AccountId($command->getId()),
            $command->getName(),
            new Currency()
        ));
    }

    public function handleDepositFundsCommand(DepositFundsCommand $command): void
    {
        /** @var Account $account */
        $account = $this->repository->load($command->getAccountId());

        if (!$account instanceof Account) {
            Result::failure(sprintf('Account %s does not exists', $command->getAccountId()));
        }

        $result = $account->addFunds($command->getAmount());

        if ($result->isFailure()) {
            throw new \Exception('Deposit failure');
        }

        $this->repository->save($account);
    }

    public function handleWithdrawFundsCommand(WithdrawFundsCommand $command): void
    {
        /** @var Account $account */
        $account = $this->repository->load($command->getAccountId());

        if (!$account instanceof Account) {
            Result::failure(sprintf('Account %s does not exists', $command->getAccountId()));
        }

        $result = $account->withdrawFunds($command->getAmount());

        if (!$result->isFailure()) {
            $this->repository->save($account);
        }
    }
}
