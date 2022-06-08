<?php

return [
    'interfaces' => [
        'google.monitoring.v3.QueryService' => [
            'QueryTimeSeries' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/timeSeries:query',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
