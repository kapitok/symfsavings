<?php
declare(strict_types=1);

namespace App\RestApi\Graphql\Mutation;

use App\Account\Application\CreateNewAccountCommand;
use App\Common\Ddd\UUID;
use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class AccountMutation implements MutationInterface, AliasedInterface
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

    public function createAccount($args)
    {
        $workCopyOfUuid = UUID::random();
        $this->commandBus->dispatch(
            new CreateNewAccountCommand(
                $workCopyOfUuid,
                $args['input']['accountName'],
                $args['input']['accountCurrency']
            )
        );

        return [
            'id' => $workCopyOfUuid,
            'name' => $args['input']['accountName'],
            'currency' => $args['input']['accountCurrency'],
        ];
    }

    /**
     * Returns methods aliases.
     *
     * For instance:
     * array('myMethod' => 'myAlias')
     *
     * @return array
     */
    public static function getAliases(): array
    {
        return [
            'createAccount' => 'createAccount',
        ];
    }
}
