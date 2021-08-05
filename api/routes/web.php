<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Repositories\Contracts\SignupTrackingRepository;
use App\Services\Charts\WeeklyRetentionService;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/test', function() {
    return ['test'];
});

$router->get('/', function () use ($router) {

    $ser = app(WeeklyRetentionService::class);

    return $ser->getChartData(['start_date' => '2016-07-19']);

    $repo = app(SignupTrackingRepository::class);

    $data = $repo->getAll();

    return $data->whereBetween('created_at', ['2016-07-20', '2016-07-21']);


    return 'hello world';
});
