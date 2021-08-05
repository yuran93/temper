<?php

namespace App\Http\Controllers;

use App\Services\Charts\WeeklyRetentionService;
use Illuminate\Http\JsonResponse;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class WeeklyRetentionChartController extends Controller
{
    protected $response;
    protected $request;
    protected $service;

    public function __construct(
        WeeklyRetentionService $service,
        ApiResponse $response,
        Request $request
    ) {
        $this->response = $response;
        $this->request = $request;
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        $startDate = $this->request->get('start_date');
        $endDate = $this->request->get('end_date');

        try {
            $data =  $this->service->getChartData(['start_date' => $startDate, 'end_date' => $endDate]);

            return $this->response->success($data);
        }
        catch(\Exception $exception) {
            return $this->response->failed($exception->getMessage());
        }
    }
}
