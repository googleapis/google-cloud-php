<?php

return [
    'interfaces' => [
        'google.cloud.support.v2.CaseAttachmentService' => [
            'ListAttachments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAttachments',
                ],
            ],
        ],
    ],
];
