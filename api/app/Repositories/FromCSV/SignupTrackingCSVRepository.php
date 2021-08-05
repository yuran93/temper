<?php

namespace App\Repositories\FromCSV;

use App\Repositories\Contracts\SignupTrackingRepository;
use Illuminate\Support\Collection;
use App\Models\SignupTracking;
use App\Services\CSVReader;

class SignupTrackingCSVRepository implements SignupTrackingRepository
{
    protected $reader;

    public function __construct(CSVReader $reader)
    {
        $this->reader = $reader;
    }

    public function getAll(): Collection
    {
        return $this->reader
            ->toCollection(storage_path('csv/export.csv'), SignupTracking::class);
    }
}
