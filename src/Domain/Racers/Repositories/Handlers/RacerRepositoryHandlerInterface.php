<?php

declare(strict_types=1);

namespace Domain\Racers\Repositories\Handlers;

use Illuminate\Support\Collection;

interface RacerRepositoryHandlerInterface
{
    public function all(): Collection;
}
