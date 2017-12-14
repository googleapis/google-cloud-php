<?php

return [
    'interfaces' => [
        'google.privacy.dlp.v2beta1.DlpService' => [
            'InspectContent' => [
                'method' => 'post',
                'uri' => '/v2beta1/content:inspect',
                'body' => '*',
            ],
            'RedactContent' => [
                'method' => 'post',
                'uri' => '/v2beta1/content:redact',
                'body' => '*',
            ],
            'DeidentifyContent' => [
                'method' => 'post',
                'uri' => '/v2beta1/content:deidentify',
                'body' => '*',
            ],
            'AnalyzeDataSourceRisk' => [
                'method' => 'post',
                'uri' => '/v2beta1/dataSource:analyze',
                'body' => '*',
            ],
            'CreateInspectOperation' => [
                'method' => 'post',
                'uri' => '/v2beta1/inspect/operations',
                'body' => '*',
            ],
            'ListInspectFindings' => [
                'method' => 'get',
                'uri' => '/v2beta1/{name=inspect/results/*}/findings',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListInfoTypes' => [
                'method' => 'get',
                'uri' => '/v2beta1/rootCategories/{category=*}/infoTypes',
                'placeholders' => [
                    'category' => [
                        'getCategory',
                    ],
                ],
            ],
            'ListRootCategories' => [
                'method' => 'get',
                'uri' => '/v2beta1/rootCategories',
            ],
        ],
    ],
];
