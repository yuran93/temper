<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Exception;

class CSVReader
{
    # Note: 1st row is considered as the header row.
    public function toCollection(string $file, string $modelClass): Collection
    {
        $collection = collect();

        $data = $this->readFrom($file);

        $header = array_shift($data);

        $model = app($modelClass);

        # Lets check we got the fields in proper format.
        if (count(array_diff($header, $model->getFillable()))) {

            Log::error('CSVReader(toCollection): File data format did not match up.');

            throw new Exception('File format did not match up.');

        }

        foreach($data as $datum) {

            # Validation so we don't get any empty lines.
            if ( is_array($datum) ) {

                # Lets resolves a model and fill up with data.
                $model = app($modelClass);

                $model->fill(array_combine($header, $datum));

                $collection->push($model);

            }

        }

        return $collection;
    }

    public function readFrom($file, $delimiter = ';'): array
    {
        $data = [];

        try {
            $handle = fopen($file, 'r');

            while (!feof($handle)) {
                $data[] = fgetcsv($handle, 0, $delimiter);
            }

            fclose($handle);
        }
        catch (Exception $exception) {
            Log::error("CSVReader(readFrom): Unable to read from file: {$file} | Error: " . $exception->getMessage());

            throw new Exception('Unable to open csv file.');
        }

        return $data;
    }
}
