<?php

namespace App\Services\Charts;

abstract class AbstractHighchartService
{
    abstract public function getChartData(array $params = []): array;

    public function getChartOptions(string $title, string $xAxis, string $yAxis, array $labels, array $series): array
    {
        return [
            'title' => [
                'text' => $title,
            ],

            'xAxis' => [
                'categories' => $labels,
                'accessibility' => [
                    'rangeDescription' => $xAxis,
                ],
            ],

            'yAxis' => [
                'title' => [
                    'text' => $yAxis,
                ],
            ],

            'legend' => [
                'layout' => "vertical",
                'align' => "right",
                'verticalAlign' => "middle",
            ],

            'plotOptions' => [
                'series' => [

                    'pointPlacement' => 'on',
                ],
            ],

            'series' => $series,

            'responsive' => [
                'rules' => [
                    [
                        'condition' => [
                            'maxWidth' => 500,
                        ],
                        'chartOptions' => [
                            'legend' => [
                                'layout' => "horizontal",
                                'align' => "center",
                                'verticalAlign' => "bottom",
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
