<?php

declare(strict_types=1);

namespace Support;

abstract class AbstractModel
{
    public function __construct(public readonly string $name)
    {
    }
}
