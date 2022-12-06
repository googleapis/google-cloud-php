<?php

return [
    'interfaces' => [
        'google.api.servicecontrol.v1.QuotaController' => [
            'AllocateQuota' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}:allocateQuota',
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
