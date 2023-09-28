<?php

declare(strict_types=1);

namespace Domain\Reports\RaceSummary;

use Domain\Attempts\DataTransferObjects\AttemptData;
use Domain\Attempts\Repositories\AttemptRepository;
use Domain\Racers\DataTransferObjects\RacerData;
use Domain\Racers\Factories\RacerFactory;
use Domain\Racers\Models\Racer;
use Domain\Racers\Repositories\RacerRepository;
use Domain\Reports\AbstractReport;
use Illuminate\Support\Collection;

class RaceSummaryReport extends AbstractReport
{
    private Collection $racers;

    public function __construct(
        private readonly RacerRepository $racerRepository,
        private readonly AttemptRepository $attemptRepository
    ) {
        $this->racers = Collection::make();
    }

    public function build(): static
    {
        $this->fetchRacers();

        $this->bindAttempts();

        $this->sortRacers();

        $this->prepareRows();

        return $this;
    }

    protected function bindAttempts(): void
    {
        $this->attemptRepository
            ->all()
            ->groupBy(fn (AttemptData $attemptData): int => $attemptData->racerId)
            ->each(function (Collection $attemptDataCollection, $racerId) {
                /** @var Racer $racer */
                $racer = $this->racers->get($racerId);

                $attemptDataCollection->each(fn (AttemptData $attemptData) => $racer->addAttempt($attemptData->score));
            });
    }

    protected function fetchRacers(): void
    {
        $this->racers = $this->racerRepository
            ->all()
            ->keyBy(fn (RacerData $racerData): int => $racerData->id)
            ->map(fn (RacerData $racerData): Racer => RacerFactory::fromRacerData($racerData));
    }

    protected function sortRacers(): void
    {
        $this->racers = $this->racers
            ->sortBy([
                fn (Racer $racer1, Racer $racer2) => $racer2->getOverallScore() <=> $racer1->getOverallScore(),
                fn (Racer $racer1, Racer $racer2) => $racer2->getAttempt(4)->score <=> $racer1->getAttempt(4)->score,
                fn (Racer $racer1, Racer $racer2) => $racer2->getAttempt(3)->score <=> $racer1->getAttempt(3)->score,
                fn (Racer $racer1, Racer $racer2) => $racer2->getAttempt(2)->score <=> $racer1->getAttempt(2)->score,
                fn (Racer $racer1, Racer $racer2) => $racer2->getAttempt(1)->score <=> $racer1->getAttempt(1)->score,
                fn (Racer $racer1, Racer $racer2) => $racer1->person->name <=> $racer2->person->name,
            ]);
    }

    protected function prepareRows(): void
    {
        $this->racers->values()->each(function (Racer $racer, int $key) {
            $this->rows[] = [
                $key + 1,
                "{$racer->person->name} [$racer->id]",
                $racer->location->name,
                $racer->car->name,
                $racer->getAttempt(1)->score,
                $racer->getAttempt(2)->score,
                $racer->getAttempt(3)->score,
                $racer->getAttempt(4)->score,
                $racer->getOverallScore(),
            ];
        });
    }

    public function headers(): array
    {
        return [
            '#',
            'Имя',
            'Город',
            'Автомобиль',
            'I',
            'II',
            'III',
            'IV',
            'Всего',
        ];
    }
}
