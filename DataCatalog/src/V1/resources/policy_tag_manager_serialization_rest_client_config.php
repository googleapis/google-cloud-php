<?php

return [
    'interfaces' => [
        'google.cloud.datacatalog.v1.PolicyTagManagerSerialization' => [
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
            'ReplaceTaxonomy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/taxonomies/*}:replace',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
