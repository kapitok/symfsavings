<?php
declare(strict_types=1);

namespace App\RestApi\Graphql\Resolver;

use App\Account\Infrastructure\AccountEventStoreRepository;
use Broadway\ReadModel\Repository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class AccountResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var AccountEventStoreRepository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function resolveAccount(Argument $args)
    {
        return $this->repository->find($args['id']);
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
            'resolveAccount' => 'Account'
        ];
    }
}
