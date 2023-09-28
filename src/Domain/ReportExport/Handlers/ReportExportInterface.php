<?php

declare(strict_types=1);

namespace Domain\ReportExport\Handlers;

use Domain\Reports\ReportInterface;

interface ReportExportInterface
{
    public function handle(ReportInterface $report): void;
}
