<?php

return [
    'interfaces' => [
        'google.cloud.datacatalog.v1.PolicyTagManagerSerialization' => [
            'ImportTaxonomies' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/taxonomies:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ExportTaxonomies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/taxonomies:export',
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
