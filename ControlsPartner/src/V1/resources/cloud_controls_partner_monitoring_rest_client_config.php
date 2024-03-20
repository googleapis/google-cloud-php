<?php

return [
    'interfaces' => [
        'google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerMonitoring' => [
            'GetViolation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/customers/*/workloads/*/violations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListViolations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*/customers/*/workloads/*}/violations',
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
