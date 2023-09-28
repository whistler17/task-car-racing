<?php

declare(strict_types=1);

namespace Domain\ReportExport\Handlers;

use Domain\Reports\ReportInterface;

class HTMLRenderer implements ReportExportInterface
{
    public function handle(ReportInterface $report): void
    {
        $headers = $report->headers();
        $rows = $report->rows();

        include 'html_template.php';
    }
}
