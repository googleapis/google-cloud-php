<?php

return [
    'interfaces' => [
        'google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1' => [
            'ListAttestors' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAttestors',
                ],
            ],
        ],
    ],
];
