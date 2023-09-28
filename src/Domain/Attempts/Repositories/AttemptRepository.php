<?php

declare(strict_types=1);

namespace Domain\Attempts\Repositories;

use App\Config;
use Domain\Attempts\Repositories\Handlers\AttemptRepositoryHandlerInterface;
use Illuminate\Support\Collection;
use Throwable;

class AttemptRepository
{
    private AttemptRepositoryHandlerInterface $handler;

    public function __construct()
    {
        try {
            $this->handler = new (Config::get('repository.attempts'));
        } catch (Throwable $e) {
            exit($e->getMessage());
        }
    }

    public function all(): Collection
    {
        return $this->handler->all();
    }
}
