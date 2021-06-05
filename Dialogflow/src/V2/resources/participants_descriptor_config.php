<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Participants' => [
            'ListParticipants' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getParticipants',
                ],
            ],
        ],
    ],
];
