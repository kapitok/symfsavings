<?php
declare(strict_types=1);

namespace App\Common\Shared;

use App\Common\Ddd\UUID;

final class AccountId
{
    /**
     * @var UUID
     */
    private $id;

    public function __construct(UUID $id)
    {
        $this->id = $id;
    }

    public static function newOne(): self
    {
        return new self(UUID::random());
    }

    public static function fromString(string $id): self
    {
        return new self(new UUID($id));
    }

    public function isEqual(self $id): bool
    {
        return $this->id->isEqual($id->id);
    }

    public function __toString()
    {
        return $this->id->__toString();
    }

    public function getValue(): UUID
    {
        return $this->id;
    }
}
