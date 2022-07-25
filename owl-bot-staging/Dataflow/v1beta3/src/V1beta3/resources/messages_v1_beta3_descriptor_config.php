<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.MessagesV1Beta3' => [
            'ListJobMessages' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getJobMessages',
                ],
            ],
        ],
    ],
];
