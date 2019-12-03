<?php
declare(strict_types=1);

namespace App\Account\Domain\ReadModel;

use App\Account\Domain\AccountCreated;
use App\Account\Domain\AccountDeposited;
use App\Account\Domain\AccountWithdrew;
use App\Common\Shared\AccountId;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class AccountDetailsProjector extends Projector
{
    /**
     * @var AccountDetailsRepository
     */
    private $accountDetailsRepository;

    public function __construct(Repository $accountDetailsRepository)
    {
        $this->accountDetailsRepository = $accountDetailsRepository;
    }

    public function applyAccountCreated(AccountCreated $event): void
    {
        $readModel = $this->getReadModel($event->getAccountId());

        $readModel->setName($event->getName());
        $readModel->setCurrency($event->getCurrency());
        $readModel->setBalance(0.0);

        $this->accountDetailsRepository->save($readModel);
    }

    public function applyAccountDeposited(AccountDeposited $event)
    {
        $readModel = $this->getReadModel($event->getAccountId());

        // Move this logic to event and aggregate
        $readModel->setBalance($readModel->getBalance() + $event->getAmount());

        $this->accountDetailsRepository->save($readModel);
    }

    public function applyAccountWithdrew(AccountWithdrew $event)
    {
        $readModel = $this->getReadModel($event->getAccountId());

        // Move this logic to event and aggregate
        $readModel->setBalance($readModel->getBalance() - $event->getAmount());

        $this->accountDetailsRepository->save($readModel);
    }

    private function getReadModel(AccountId $accountId): AccountDetails
    {
        $readModel = $this->accountDetailsRepository->find((string) $accountId);

        if (null === $readModel) {
            $readModel = new AccountDetails($accountId);
        }

        return $readModel;
    }
}
