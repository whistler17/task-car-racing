<?php

declare(strict_types=1);

namespace Domain\Reports;

abstract class AbstractReport implements ReportInterface
{
    protected array $rows = [];

    public function headers(): array
    {
        return [];
    }

    public function rows(): array
    {
        return $this->rows;
    }
}
