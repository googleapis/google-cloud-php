<?php

return [
    'interfaces' => [
        'google.cloud.gsuiteaddons.v1.GSuiteAddOns' => [
            'ListDeployments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDeployments',
                ],
            ],
        ],
    ],
];
