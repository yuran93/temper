<?php

namespace App\Http\Controllers;

use App\Services\Charts\WeeklyRetentionService;

class WeeklyRetentionChartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __invoke(WeeklyRetentionService $weeklyRetentionService)
    {
        return $weeklyRetentionService->getChartData(['start_date' => '2016-07-19']);
    }
}
