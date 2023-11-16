<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.CatalogService' => [
            'AddCatalogAttribute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'GetAttributesConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCompletionConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\CompletionConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDefaultBranch' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\GetDefaultBranchResponse',
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'ListCatalogs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCatalogs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ListCatalogsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveCatalogAttribute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'ReplaceCatalogAttribute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'SetDefaultBranch' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'UpdateAttributesConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config.name',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCatalog' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\Catalog',
                'headerParams' => [
                    [
                        'keyName' => 'catalog.name',
                        'fieldAccessors' => [
                            'getCatalog',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCompletionConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\CompletionConfig',
                'headerParams' => [
                    [
                        'keyName' => 'completion_config.name',
                        'fieldAccessors' => [
                            'getCompletionConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'attributesConfig' => 'projects/{project}/locations/{location}/catalogs/{catalog}/attributesConfig',
                'branch' => 'projects/{project}/locations/{location}/catalogs/{catalog}/branches/{branch}',
                'catalog' => 'projects/{project}/locations/{location}/catalogs/{catalog}',
                'completionConfig' => 'projects/{project}/locations/{location}/catalogs/{catalog}/completionConfig',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
