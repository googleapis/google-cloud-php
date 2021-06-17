<?php

return [
    'interfaces' => [
        'google.cloud.apigeeconnect.v1.ConnectionService' => [
            'ListConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/endpoints/*}/connections',
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
];
