<?php

return [
    'interfaces' => [
        'google.api.servicecontrol.v1.ServiceController' => [
            'Check' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}:check',
                'body' => '*',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'Report' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}:report',
                'body' => '*',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
