<?php

declare(strict_types=1);

namespace Domain\Racers\Models;

use Domain\Attempts\Models\Attempt;
use Domain\Cars\Models\Car;
use Domain\Location\Models\Location;
use Domain\Persons\Models\Person;
use Illuminate\Support\Collection;

class Racer
{
    protected array $attempts = [];

    public function __construct(
        public readonly int $id,
        public readonly Person $person,
        public readonly Car $car,
        public readonly Location $location
    ) {
    }

    public function addAttempt(int $score): void
    {
        $number = count($this->attempts) + 1;

        $attempt = new Attempt($number, $score);

        $this->attempts[$attempt->number] = $attempt;
    }

    public function getOverallScore(): int
    {
        return Collection::make($this->attempts)->sum(fn (Attempt $attempt): int => $attempt->score);
    }

    public function getAttempt($number): ?Attempt
    {
        return array_key_exists($number, $this->attempts) ? $this->attempts[$number] : null;
    }
}
