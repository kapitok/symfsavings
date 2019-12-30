<?php
declare(strict_types=1);

namespace App\RestApi\Graphql\Mutation;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class AccountMutation implements MutationInterface, AliasedInterface
{

    public function createAccount($args)
    {
        return ['name' => $args['input']['name']];
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
