<?php

declare(strict_types=1);

namespace Domain\Attempts\Models;

class Attempt
{
    public function __construct(
        public readonly int $number,
        public readonly int $score
    ) {
    }
}
