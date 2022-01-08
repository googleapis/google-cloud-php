<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.EventService' => [
            'CreateClientEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/clientEvents',
                'body' => 'client_event',
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
