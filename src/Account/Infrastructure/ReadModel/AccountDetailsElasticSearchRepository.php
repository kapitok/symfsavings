<?php
declare(strict_types=1);

namespace App\Account\Infrastructure\ReadModel;

use App\Account\Domain\ReadModel\AccountDetailsRepository;
use Broadway\ReadModel\ElasticSearch\ElasticSearchRepository;

class AccountDetailsElasticSearchRepository extends ElasticSearchRepository implements AccountDetailsRepository
{
}
