<?php

namespace App\Http\Controllers;

use App\Services\Charts\WeeklyRetentionService;
use App\Services\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
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
        $startDate = $this->request->get('start_date', '2016-07-19');

        $data =  $this->service->getChartData(['start_date' => $startDate]);

        return $this->response->success($data);
    }
}
