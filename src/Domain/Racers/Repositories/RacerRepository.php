<?php

declare(strict_types=1);

namespace Domain\Racers\Repositories;

use App\Config;
use Domain\Racers\Repositories\Handlers\RacerRepositoryHandlerInterface;
use Illuminate\Support\Collection;
use Throwable;

class RacerRepository
{
    private RacerRepositoryHandlerInterface $handler;

    public function __construct()
    {
        try {
            $this->handler = new (Config::get('repository.racers'));
        } catch (Throwable $e) {
            exit($e->getMessage());
        }
    }

    public function all(): Collection
    {
        return $this->handler->all();
    }
}
