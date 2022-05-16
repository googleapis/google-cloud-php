<?php

return [
    'interfaces' => [
        'google.cloud.iap.v1.IdentityAwareProxyAdminService' => [
            'ListTunnelDestGroups' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTunnelDestGroups',
                ],
            ],
        ],
    ],
];
