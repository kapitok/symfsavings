<?php
declare(strict_types=1);

namespace App\RestApi;

use App\Account\Application\CreateNewAccountCommand;
use App\Account\Application\DepositFundsCommand;
use App\Account\Application\WithdrawFundsCommand;
use App\Account\Domain\ReadModel\AccountDetails;
use App\Account\Domain\ReadModel\AccountDetailsRepository;
use App\Common\Ddd\UUID;
use App\Common\Shared\AccountId;
use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:create-account';

    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var AccountDetailsRepository
     */
    private $repo;

    public function __construct(CommandBus $commandBus, Repository $repo)
    {
        $this->commandBus = $commandBus;
        $this->repo = $repo;

        parent::__construct();
    }

    protected function configure()
    {
        $this
        ->setDescription('Create a new account.')
        ->setHelp('This command allows you to create a new account...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('start');

        $workCopyOfUuid = UUID::random();
        $this->commandBus->dispatch(
            new CreateNewAccountCommand(
                $workCopyOfUuid,
                'MyFirstAccount 3',
                'pln'
            )
        );
        $this->showAccountInfo('after create', $workCopyOfUuid, $output);

        $this->commandBus->dispatch(
            new DepositFundsCommand(new AccountId($workCopyOfUuid), 300.00)
        );
        $this->showAccountInfo('after deposit 300.00', $workCopyOfUuid, $output);

        $this->commandBus->dispatch(
            new WithdrawFundsCommand(new AccountId($workCopyOfUuid), 150)
        );
        $this->showAccountInfo('after withdraw 150', $workCopyOfUuid, $output);

        $this->commandBus->dispatch(
            new DepositFundsCommand(new AccountId($workCopyOfUuid), 100)
        );
        $this->showAccountInfo('after deposit 100', $workCopyOfUuid, $output);

        $output->writeln('finish');
    }

    protected function showAccountInfo(string $action, $accountId, OutputInterface $output)
    {
        /** @var AccountDetails $readModel */
        $readModel = $this->repo->find($accountId);

        $output->writeln(str_repeat('---', 50));
        $output->writeln([$action, $readModel->getName(), $readModel->getCurrency(), $readModel->getBalance()]);
        $output->writeln(str_repeat('---', 50));
    }
}
