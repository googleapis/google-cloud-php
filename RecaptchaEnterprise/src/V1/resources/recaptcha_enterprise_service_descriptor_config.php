<?php

return [
    'interfaces' => [
        'google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService' => [
            'ListKeys' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getKeys',
                ],
            ],
        ],
    ],
];
