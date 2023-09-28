<?php

declare(strict_types=1);

namespace Domain\ReportExport\Handlers;

use App\Config;
use Domain\Reports\ReportInterface;
use Throwable;

class CSVExport implements ReportExportInterface
{
    public function handle(ReportInterface $report): void
    {
        try {
            $filePath = Config::get('file.csv_export');

            $fileHandle = fopen($filePath, 'w+b');

            fputcsv($fileHandle, $report->headers(), ';');

            foreach ($report->rows() as $row) {
                fputcsv($fileHandle, $row, ';');
            }

            fclose($fileHandle);
        } catch (Throwable $e) {
            die('Ошибка при работе с файлом');
        }
    }
}
