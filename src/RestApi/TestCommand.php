<?php
declare(strict_types=1);

namespace App\RestApi;

use App\Account\Application\CreateNewAccountCommand;
use App\Account\Application\DepositFundsCommand;
use App\Account\Application\WithdrawFundsCommand;
use App\Common\Ddd\UUID;
use App\Common\Shared\AccountId;
use Broadway\CommandHandling\CommandBus;
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

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

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

        $this->commandBus->dispatch(
            new DepositFundsCommand(new AccountId($workCopyOfUuid), 300.05)
        );

        $this->commandBus->dispatch(
            new WithdrawFundsCommand(new AccountId($workCopyOfUuid), 150)
        );

        $this->commandBus->dispatch(
            new DepositFundsCommand(new AccountId($workCopyOfUuid), 100)
        );

        $output->writeln('finish');
    }
}
