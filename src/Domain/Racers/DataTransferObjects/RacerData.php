<?php

declare(strict_types=1);

namespace Domain\Racers\DataTransferObjects;

readonly class RacerData
{
    public function __construct(
        public int $id,
        public string $personName,
        public string $carName,
        public string $locationName,
    ) {
    }
}
