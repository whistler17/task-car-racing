<?php

declare(strict_types=1);

namespace Domain\Reports;

interface ReportInterface
{
    public function build(): static;

    public function headers(): array;

    public function rows(): array;
}
