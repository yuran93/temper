<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CSVReader
{
    # Note: 1st row is considered as the header row.
    public function toCollection(string $file, string $modelClass): Collection
    {
        $collection = collect();

        $data = $this->readFrom($file);

        $header = array_shift($data);

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

        $handle = fopen($file, 'r');

        while (!feof($handle)) {
            $data[] = fgetcsv($handle, 0, $delimiter);
        }
        fclose($handle);

        return $data;
    }
}
