<?php

return [
    'interfaces' => [
        'google.cloud.accessapproval.v1.AccessApproval' => [
            'ListApprovalRequests' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getApprovalRequests',
                ],
            ],
        ],
    ],
];
