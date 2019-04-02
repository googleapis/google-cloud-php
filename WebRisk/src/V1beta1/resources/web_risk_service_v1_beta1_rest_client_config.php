<?php

return [
    'interfaces' => [
        'google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1' => [
            'ComputeThreatListDiff' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/threatLists:computeDiff',
            ],
            'SearchUris' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/uris:search',
            ],
            'SearchHashes' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/hashes:search',
            ],
        ],
    ],
];
