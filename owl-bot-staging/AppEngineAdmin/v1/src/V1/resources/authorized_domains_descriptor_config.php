<?php

return [
    'interfaces' => [
        'google.appengine.v1.AuthorizedDomains' => [
            'ListAuthorizedDomains' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDomains',
                ],
            ],
        ],
    ],
];
