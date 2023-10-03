<?php

return [
    'interfaces' => [
        'google.shopping.merchant.inventories.v1beta.LocalInventoryService' => [
            'ListLocalInventories' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocalInventories',
                ],
            ],
        ],
    ],
];
