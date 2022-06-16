<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.KnowledgeBases' => [
            'ListKnowledgeBases' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getKnowledgeBases',
                ],
            ],
        ],
    ],
];
