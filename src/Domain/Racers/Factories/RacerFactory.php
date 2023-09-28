<?php

declare(strict_types=1);

namespace Domain\Racers\Factories;

use Domain\Cars\Models\Car;
use Domain\Location\Models\Location;
use Domain\Persons\Models\Person;
use Domain\Racers\DataTransferObjects\RacerData;
use Domain\Racers\Models\Racer;

class RacerFactory
{
    public static function fromRacerData(RacerData $racerData): Racer
    {
        return new Racer(
            id: $racerData->id,
            person: new Person($racerData->personName),
            car: new Car($racerData->carName),
            location: new Location($racerData->locationName)
        );
    }
}
