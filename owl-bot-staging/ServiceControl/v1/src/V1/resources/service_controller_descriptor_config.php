<?php

return [
    'interfaces' => [
        'google.api.servicecontrol.v1.ServiceController' => [
            'Check' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ServiceControl\V1\CheckResponse',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'Report' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ServiceControl\V1\ReportResponse',
                'headerParams' => [
                    [
                        'keyName' => 'service_name',
                        'fieldAccessors' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
