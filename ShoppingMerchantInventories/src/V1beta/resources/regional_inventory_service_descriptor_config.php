<?php

return [
    'interfaces' => [
        'google.shopping.merchant.inventories.v1beta.RegionalInventoryService' => [
            'ListRegionalInventories' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRegionalInventories',
                ],
            ],
        ],
    ],
];
