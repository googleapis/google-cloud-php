<?php

return [
    'interfaces' => [
        'google.api.servicecontrol.v1.QuotaController' => [
            'AllocateQuota' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ServiceControl\V1\AllocateQuotaResponse',
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
