<?php

namespace App\Common\Ddd;

final class Failure extends Result
{
    /**
     * @var string
     */
    protected $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }
}
