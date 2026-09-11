<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Streams a query straight to the browser as CSV.
 *
 * Filament ships a queue-backed exporter, but that needs three extra tables and
 * a running worker. These lists are small and the team wants the file now, so a
 * synchronous stream is the better trade here.
 */
class CsvExport
{
    /**
     * @param  array<string, string>  $columns  header label keyed by attribute
     */
    public static function stream(Builder $query, array $columns, string $filename): StreamedResponse
    {
        return response()->streamDownload(function () use ($query, $columns) {
            $handle = fopen('php://output', 'w');

            // Excel assumes the system encoding without this.
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, array_values($columns));

            $query->chunk(500, function ($records) use ($handle, $columns) {
                foreach ($records as $record) {
                    fputcsv($handle, array_map(
                        fn (string $attribute) => (string) data_get($record, $attribute),
                        array_keys($columns),
                    ));
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
