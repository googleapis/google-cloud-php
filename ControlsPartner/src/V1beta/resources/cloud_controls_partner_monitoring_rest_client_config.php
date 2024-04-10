<?php

return [
    'interfaces' => [
        'google.cloud.cloudcontrolspartner.v1beta.CloudControlsPartnerMonitoring' => [
            'GetViolation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/customers/*/workloads/*/violations/*}',
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
                'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*/customers/*/workloads/*}/violations',
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
