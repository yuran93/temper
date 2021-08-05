<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface SignupTrackingRepository
{
    # Ideally we want to extend from an base interface
    # But lets just keep things simple for the moment.

    public function getAll(): Collection;
}
