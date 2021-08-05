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
        $this->get('/api/weekly-retention?start_date=2020-01-01&end_date=2021-01-01');

        $this->assertEquals(200, $this->response->status());
    }
}
