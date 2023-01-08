<?php

return [
    'interfaces' => [
        'google.monitoring.v3.AlertPolicyService' => [
            'ListAlertPolicies' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAlertPolicies',
                ],
            ],
        ],
    ],
];
