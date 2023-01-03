<?php

return [
    'interfaces' => [
        'google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1' => [
            'ComputeThreatListDiff' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/threatLists:computeDiff',
            ],
            'SearchHashes' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/hashes:search',
            ],
            'SearchUris' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/uris:search',
            ],
        ],
    ],
];
