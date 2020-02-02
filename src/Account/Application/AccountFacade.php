<?php
declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Domain\ReadModel\AccountDetails;
use App\Common\Ddd\UUID;
use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;

class AccountFacade
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var Repository
     */
    private $repo;

    public function __construct(CommandBus $commandBus, Repository $repo)
    {
        $this->commandBus = $commandBus;
        $this->repo = $repo;
    }

    public function createAccount(string $name, string $currency): AccountDetails
    {
        $workCopyOfUuid = UUID::random();

        $this->commandBus->dispatch(
            new CreateNewAccountCommand(
                $workCopyOfUuid,
                $name,
                $currency
            )
        );

        return $this->repo->find($workCopyOfUuid);
    }

    public function depositAccount(): void
    {
    }

    public function withdrawAccount(): void
    {
    }
}
