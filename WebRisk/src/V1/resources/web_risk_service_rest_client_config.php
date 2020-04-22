<?php

return [
    'interfaces' => [
        'google.cloud.webrisk.v1.WebRiskService' => [
            'ComputeThreatListDiff' => [
                'method' => 'get',
                'uriTemplate' => '/v1/threatLists:computeDiff',
            ],
            'SearchUris' => [
                'method' => 'get',
                'uriTemplate' => '/v1/uris:search',
            ],
            'SearchHashes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/hashes:search',
            ],
            'CreateSubmission' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/submissions',
                'body' => 'submission',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
