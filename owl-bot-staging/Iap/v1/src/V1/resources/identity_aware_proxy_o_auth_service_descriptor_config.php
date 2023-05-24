<?php

return [
    'interfaces' => [
        'google.cloud.iap.v1.IdentityAwareProxyOAuthService' => [
            'ListIdentityAwareProxyClients' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getIdentityAwareProxyClients',
                ],
            ],
        ],
    ],
];
