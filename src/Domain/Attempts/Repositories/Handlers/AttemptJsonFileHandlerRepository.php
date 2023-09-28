<?php

declare(strict_types=1);

namespace Domain\Attempts\Repositories\Handlers;

use App\Config;
use Domain\Attempts\DataTransferObjects\AttemptData;
use Exception;
use Illuminate\Support\Collection;
use Throwable;

class AttemptJsonFileHandlerRepository implements AttemptRepositoryHandlerInterface
{
    private string $filePath;

    protected ?Collection $items = null;

    public function __construct()
    {
        $this->filePath = Config::get('file.data_attempts');
    }

    public function all(): Collection
    {
        if ($this->items === null) {
            $this->items = Collection::make();

            try {
                foreach ($this->getRawItems() as $item) {
                    try {
                        [$racerId, $score] = array_values($item);

                        $attempt = new AttemptData(
                            racerId: $racerId,
                            score: $score
                        );

                        $this->items->add($attempt);
                    } catch (Throwable $e) {
                        exit($e);
                    }
                }
            } catch (Throwable $e) {
                exit($e);
            }
        }

        return $this->items;
    }

    /**
     * @throws Exception
     */
    protected function validate(array $items): void
    {
        /** @var Collection $racerIdsInAttemptFile */
        $racerIdsInAttemptFile = Collection::make($items)
            ->groupBy('id')
            ->map(fn (Collection $attempts): int => $attempts->count());

        if ($racerIdsInAttemptFile->unique()->count() > 1) {
            throw new Exception('Некоторые участники сделали больше или меньше заездов, чем остальные');
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
