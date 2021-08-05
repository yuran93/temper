<?php

namespace App\Services\Charts;

use App\Repositories\Contracts\SignupTrackingRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WeeklyRetentionService extends AbstractHighchartService
{
    protected $repository;

    public function __construct(SignupTrackingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getChartData(array $params = []): array
    {
        # No of weeks for the x axies.
        $noOfWeeks = Arr::get($params, 'no_of_weeks', 12);

        $startDate = Arr::get($params, 'start_date');
        $endDate = Arr::get($params, 'end_date');

        if ( !$startDate || !$endDate ) {
            throw new \Exception('Missing mandatory params: start_date, end_date');
        }

        # Lets create Carbon objects from the dates.
        $startAt = Carbon::parse($startDate);
        $endAt = Carbon::parse($endDate);

        $monitoringPeriod = $startAt->diffInWeeks($endAt);

        if ( $monitoringPeriod < 1 ) {
            throw new \Exception('Invalid date period');
        }

        $collection = $this->repository->getAll();

        list($series, $labels) = $this->getSeriesAndLabelData($collection, $startAt, $monitoringPeriod, $noOfWeeks);

        return $this->getChartOptions(
            'WEEKLY RETENTION CURVES - MIXPANEL DATA', 'Weeks',
            'Retention Percentage',
            $labels,
            $series
        );
    }

    public function getSeriesAndLabelData(Collection $collection, Carbon $startAt, int $monitoringPeriod, $noOfWeeks): array
    {
        $labels = [];
        $series = [];

        # Initial loop to get the series going.
        # As we move forward with this it'll shift the time period by week.
        for($seriesNo = 0; $seriesNo < $monitoringPeriod; $seriesNo++) {

            # This loop is to get the weekly data of a single series.
            for ($week = 0; $week < $noOfWeeks; $week++) {

                # Lets get the name based on the series start date.
                $name = (clone $startAt)->addWeeks($seriesNo)->toDateString();

                # This will give us the exact period that we're looking for.
                $periodStart = (clone $startAt)->addWeeks($seriesNo + $week)->toDateString();
                $periodEnd = (clone $startAt)->addWeeks($seriesNo + $week + 1)->toDateString();

                # Lets filter the stats out from out collection based on the period.
                $percentage = $collection
                    ->whereBetween('created_at', [$periodStart, $periodEnd])
                    ->average('onboarding_perentage');

                # Just need to fill up one time for a labels.
                if ( $seriesNo == 0 ) {
                    $labels[] = ($week + 1) . ' Weeks Later' . " {$periodStart}";
                }

                $series[$seriesNo]['name'] = $name;
                $series[$seriesNo]['data'][] = $percentage ?? 0;
            }

        }

        return [
            $series,
            $labels,
        ];
    }

}
