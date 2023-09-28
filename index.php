<?php

declare(strict_types=1);

use Domain\Attempts\Repositories\AttemptRepository;
use Domain\Racers\Repositories\RacerRepository;
use Domain\ReportExport\Handlers\CSVExport;
use Domain\ReportExport\Handlers\HTMLRenderer;
use Domain\ReportExport\Handlers\ReportExportInterface;
use Domain\Reports\RaceSummary\RaceSummaryReport;
use Illuminate\Support\Arr;

require 'vendor/autoload.php';
require 'header.php';

$report = new RaceSummaryReport(new RacerRepository(), new AttemptRepository());
$report->build();

try {
    /** @var ReportExportInterface $handler */
    $handler = match (Arr::get($_REQUEST, 'action')) {
        'csv' => new CSVExport(),
        default => new HTMLRenderer()
    };
} catch (Throwable $e) {
    die($e->getMessage());
}

$handler->handle($report);

include 'buttons.php';
