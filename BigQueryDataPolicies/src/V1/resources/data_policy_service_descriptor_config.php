<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.datapolicies.v1.DataPolicyService' => [
            'ListDataPolicies' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDataPolicies',
                ],
            ],
        ],
    ],
];
