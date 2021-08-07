<?php

namespace App\Services\Charts;

use App\Repositories\Contracts\SignupTrackingRepository;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WeeklyRetentionService extends AbstractHighchartService
{
    protected $repository;
    protected $dataset;

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

        $this->dataset = $this->repository->getAll();

        list($series, $labels) = $this->getSeriesAndLabelData($startAt, $monitoringPeriod, $noOfWeeks);

        return $this->getChartOptions(
            'WEEKLY RETENTION CURVES - MIXPANEL DATA', 'Weeks',
            'Retention Percentage',
            $labels,
            $series
        );
    }

    public function getSeriesAndLabelData(Carbon $startAt, int $monitoringPeriod, $noOfWeeks): array
    {
        $series = [];

        $onboardingPercentages = [
            0 => 'Create account',
            20 => 'Activate account',
            40 => 'Provide profile information',
            50 => 'What jobs are you interested in?',
            70 => 'Do you have relevant experience in these jobs?',
            90 => 'Are you a freelancer?',
            99 => 'Waiting for approval',
            100 => 'Approval',
        ];

        $labels = array_values($onboardingPercentages);

        # As we move forward with the series it'll shift the time period by week.
        for($seriesNo = 0; $seriesNo < $monitoringPeriod; $seriesNo++) {

            # This will give us the exact period that we're looking for.
            $periodStart = (clone $startAt)->addWeeks($seriesNo)->toDateString();
            $periodEnd = (clone $startAt)->addWeeks($seriesNo + 1)->toDateString();

            # Lets get the dataset belongs to that perticular series ( Week from here ).
            $seriesDataset = $this->dataset->whereBetween('created_at', [$periodStart, $periodEnd]);

            # Gets the total user count for that series.
            $seriesUserCount = $seriesDataset->count();

            # This loop is to get the weekly data of a single series.
            foreach ($onboardingPercentages as $onboardingPercentage => $onboardingPercentageLabel) {

                # Gets the count of users who are still in or been on this step.
                $stepUserCount = $seriesDataset->where('onboarding_perentage', '>=', $onboardingPercentage)->count();

                $series[$seriesNo]['type'] = 'spline';
                $series[$seriesNo]['name'] = $periodStart;
                $series[$seriesNo]['data'][] = ($seriesUserCount ? $stepUserCount / $seriesUserCount : 0) * 100;

            }

        }

        return [
            $series,
            $labels,
        ];
    }

}
