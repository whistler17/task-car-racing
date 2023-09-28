<?php

declare(strict_types=1);

namespace Domain\Attempts\Repositories\Handlers;

use Illuminate\Support\Collection;

interface AttemptRepositoryHandlerInterface
{
    public function all(): Collection;
}
