<?php

declare(strict_types=1);

namespace Domain\Racers\Repositories\Handlers;

use App\Config;
use Domain\Racers\DataTransferObjects\RacerData;
use Exception;
use Illuminate\Support\Collection;
use Throwable;

class RacerJsonFileRepositoryHandler implements RacerRepositoryHandlerInterface
{
    protected ?string $filePath;

    protected ?Collection $items = null;

    public function __construct()
    {
        $this->filePath = Config::get('file.data_cars');
    }

    public function all(): Collection
    {
        if ($this->items === null) {
            $this->items = Collection::make();

            foreach ($this->getRawItems() as $item) {
                try {
                    [$id, $personName, $locationName, $carName] = array_values($item);

                    $racer = new RacerData(
                        id: $id,
                        personName: $personName,
                        carName: $carName,
                        locationName: $locationName
                    );

                    $this->items->add($racer);
                } catch (Throwable $e) {
                    exit($e->getMessage());
                }
            }
        }

        return $this->items;
    }

    /**
     * @throws Exception
     */
    protected function validate(mixed $items): void
    {
        $uniqueIds = count(array_unique(array_column($items, 'id')));
        $totalCount = count($items);

        if ($uniqueIds != $totalCount) {
            throw new Exception('Несколько участников с одинаковым id');
        }
    }

    protected function getRawItems(): array
    {
        $dataCarsContent = file_get_contents($this->filePath);

        $data = json_decode($dataCarsContent, true);

        $items = array_key_exists('data', $data) ? $data['data'] : [];

        try {
            $this->validate($items);
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        return $items;
    }
}
