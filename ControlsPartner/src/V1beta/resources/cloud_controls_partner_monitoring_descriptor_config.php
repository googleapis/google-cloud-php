<?php

return [
    'interfaces' => [
        'google.cloud.cloudcontrolspartner.v1beta.CloudControlsPartnerMonitoring' => [
            'GetViolation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudControlsPartner\V1beta\Violation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListViolations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getViolations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\CloudControlsPartner\V1beta\ListViolationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'violation' => 'organizations/{organization}/locations/{location}/customers/{customer}/workloads/{workload}/violations/{violation}',
                'workload' => 'organizations/{organization}/locations/{location}/customers/{customer}/workloads/{workload}',
            ],
        ],
    ],
];
