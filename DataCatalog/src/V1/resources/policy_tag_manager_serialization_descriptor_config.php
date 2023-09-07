<?php

return [
    'interfaces' => [
        'google.cloud.datacatalog.v1.PolicyTagManagerSerialization' => [
            'ExportTaxonomies' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DataCatalog\V1\ExportTaxonomiesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ImportTaxonomies' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DataCatalog\V1\ImportTaxonomiesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReplaceTaxonomy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DataCatalog\V1\Taxonomy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'location' => 'projects/{project}/locations/{location}',
                'taxonomy' => 'projects/{project}/locations/{location}/taxonomies/{taxonomy}',
            ],
        ],
    ],
];
