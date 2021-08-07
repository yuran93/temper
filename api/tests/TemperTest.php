<?php

class TemperTest extends TestCase
{
    public function test_health_check()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    public function test_missing_date_params()
    {
        $this->get('/api/weekly-retention');

        $this->seeJson([
            'success' => false,
            'message' => 'Missing mandatory params: start_date, end_date',
            'status' => 500,
        ]);

        $this->assertEquals(500, $this->response->status());
    }

    public function test_invalid_period()
    {
        $this->get('/api/weekly-retention?start_date=2020-01-01&end_date=2020-01-01');

        $this->seeJson([
            'success' => false,
            'message' => 'Invalid date period',
            'status' => 500,
        ]);

        $this->assertEquals(500, $this->response->status());
    }

    public function test_valid_response()
    {
        $this->get('/api/weekly-retention?start_date=2016-07-19&end_date=2016-09-19');

        $this->assertEquals(200, $this->response->status());
    }

    public function test_valid_response_format()
    {
        $this->get('/api/weekly-retention?start_date=2016-07-19&end_date=2016-09-19');

        $json = $this->response->getContent();

        $response = json_decode($json, true);

        $validKeys = [
            'title',
            'xAxis',
            'yAxis',
            'legend',
            'plotOptions',
            'series',
            'responsive',
        ];

        $this->assertNotTrue(count(array_diff($validKeys, array_keys($response['data']))));
    }

    public function test_valid_data()
    {
        $handle = fopen(storage_path('csv/export.csv'), 'r');

        $firstWeekDates = ['2016-07-19', '2016-07-20', '2016-07-21', '2016-07-22', '2016-07-23', '2016-07-24', '2016-07-25'];

        $firstWeekPercentages = [];
        while (!feof($handle)) {
            $row = fgetcsv($handle, 0, ';');
            if ( is_array($row) && in_array($row[1], $firstWeekDates) ) {
                $firstWeekPercentages[] = $row[2];
            }
        }

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

        $totalUserCount = count($firstWeekPercentages);

        $seriesDataFromTest = [];
        foreach( $onboardingPercentages as $value => $label) {
            $stepUserCount = count(array_filter($firstWeekPercentages, function($per) use($value) {
                return $per >= $value;
            }));

            $seriesDataFromTest[] = round($totalUserCount ?  $stepUserCount / $totalUserCount * 100 : 0, 2);
        }

        fclose($handle);


        $this->get('/api/weekly-retention?start_date=2016-07-19&end_date=2016-09-19');

        $json = $this->response->getContent();

        $response = json_decode($json, true);

        $seriesDataFromAPI = $response['data']['series'][0]['data'];

        $this->assertEquals($seriesDataFromTest, $seriesDataFromAPI);
    }
}
