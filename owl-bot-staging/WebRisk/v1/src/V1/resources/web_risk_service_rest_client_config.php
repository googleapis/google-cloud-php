<?php

return [
    'interfaces' => [
        'google.cloud.webrisk.v1.WebRiskService' => [
            'ComputeThreatListDiff' => [
                'method' => 'get',
                'uriTemplate' => '/v1/threatLists:computeDiff',
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
            'SearchHashes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/hashes:search',
            ],
            'SearchUris' => [
                'method' => 'get',
                'uriTemplate' => '/v1/uris:search',
            ],
        ],
    ],
];
