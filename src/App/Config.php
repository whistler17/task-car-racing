<?php

declare(strict_types=1);

namespace App;

use Domain\Attempts\Repositories\Handlers\AttemptJsonFileHandlerRepository;
use Domain\Racers\Repositories\Handlers\RacerJsonFileRepositoryHandler;
use Illuminate\Support\Arr;

class Config
{
    private static function config(): array
    {
        return [
            'file' => [
                'data_cars' => $_SERVER['DOCUMENT_ROOT'] . '/_data/' . 'data_cars.json',
                'data_attempts' => $_SERVER['DOCUMENT_ROOT'] . '/_data/' . 'data_attempts.json',
                'csv_export' => $_SERVER['DOCUMENT_ROOT'] . '/_data/' . 'csv_export.csv',
            ],
            'repository' => [
                'racers' => RacerJsonFileRepositoryHandler::class,
                'attempts' => AttemptJsonFileHandlerRepository::class,
            ],
        ];
    }

    public static function get(string $code): ?string
    {
        return Arr::get(static::config(), $code);
    }
}
