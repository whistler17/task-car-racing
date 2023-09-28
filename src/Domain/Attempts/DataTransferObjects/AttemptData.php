<?php

declare(strict_types=1);

namespace Domain\Attempts\DataTransferObjects;

readonly class AttemptData
{
    public function __construct(
        public int $racerId,
        public int $score
    ) {
    }
}
