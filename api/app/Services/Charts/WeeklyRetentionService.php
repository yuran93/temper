<?php

namespace App\Services\Charts;

use App\Repositories\Contracts\SignupTrackingRepository;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WeeklyRetentionService extends AbstractHighchartService
{
    protected $signupTrackingRepository;

    public function __construct(SignupTrackingRepository $signupTrackingRepository)
    {
        $this->signupTrackingRepository = $signupTrackingRepository;
    }

    public function getChartData(array $params = []): array
    {
        $startDate = Arr::get($params, 'start_date');
        $noOfWeeks = Arr::get($params, 'no_of_weeks', 12);

        $collection = $this->signupTrackingRepository->getAll();

        $startAt = Carbon::parse($startDate);

        $labels = [];
        $series = [];

        for($seriesNo = 0; $seriesNo < 1; $seriesNo++) {

            for ($week = 0; $week < $noOfWeeks; $week++) {

                $periodStart = (clone $startAt)->addWeeks($week)->toDateString();
                $periodEnd = (clone $startAt)->addWeeks($week + 1)->toDateString();

                $percentage = $collection
                    ->whereBetween('created_at', [$periodStart, $periodEnd])
                    ->average('onboarding_perentage');

                # Just need to fill up one time for a labels.
                if ( $seriesNo == 0 ) {
                    $labels[] = ($week + 1) . ' Weeks Later' . " {$periodStart}";
                }

                $series[$seriesNo]['name'] = $periodStart;
                $series[$seriesNo]['data'][] = $percentage ?? 0;
            }

        }

        return $this->getChartOptions(
            'WEEKLY RETENTION CURVES - MIXPANEL DATA', 'Weeks',
            'Retention Percentage',
            $labels,
            $series
        );
    }

}
