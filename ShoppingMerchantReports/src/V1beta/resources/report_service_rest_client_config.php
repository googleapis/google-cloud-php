<?php

return [
    'interfaces' => [
        'google.shopping.merchant.reports.v1beta.ReportService' => [
            'Search' => [
                'method' => 'post',
                'uriTemplate' => '/reports/v1beta/{parent=accounts/*}/reports:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
