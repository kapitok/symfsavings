<?php
declare(strict_types=1);

namespace App\Account\Application;

use App\Common\Ddd\UUID;

class CreateNewAccountCommand
{
    /**
     * @var UUID
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $currency;

    public function __construct(UUID $id, string $name, string $currency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
    }

    /**
     * @return UUID
     */
    public function getId(): UUID
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
