<?php

return [
    'interfaces' => [
        'google.cloud.dataplex.v1.DataTaxonomyService' => [
            'CreateDataAttribute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataTaxonomies/*}/attributes',
                'body' => 'data_attribute',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'data_attribute_id',
                ],
            ],
            'CreateDataAttributeBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataAttributeBindings',
                'body' => 'data_attribute_binding',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'data_attribute_binding_id',
                ],
            ],
            'CreateDataTaxonomy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataTaxonomies',
                'body' => 'data_taxonomy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'data_taxonomy_id',
                ],
            ],
            'DeleteDataAttribute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataTaxonomies/*/attributes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataAttributeBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataAttributeBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'etag',
                ],
            ],
            'DeleteDataTaxonomy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataTaxonomies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataAttribute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataTaxonomies/*/attributes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataAttributeBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataAttributeBindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataTaxonomy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataTaxonomies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDataAttributeBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataAttributeBindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataAttributes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataTaxonomies/*}/attributes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataTaxonomies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataTaxonomies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDataAttribute' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_attribute.name=projects/*/locations/*/dataTaxonomies/*/attributes/*}',
                'body' => 'data_attribute',
                'placeholders' => [
                    'data_attribute.name' => [
                        'getters' => [
                            'getDataAttribute',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDataAttributeBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_attribute_binding.name=projects/*/locations/*/dataAttributeBindings/*}',
                'body' => 'data_attribute_binding',
                'placeholders' => [
                    'data_attribute_binding.name' => [
                        'getters' => [
                            'getDataAttributeBinding',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDataTaxonomy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_taxonomy.name=projects/*/locations/*/dataTaxonomies/*}',
                'body' => 'data_taxonomy',
                'placeholders' => [
                    'data_taxonomy.name' => [
                        'getters' => [
                            'getDataTaxonomy',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/zones/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/zones/*/assets/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/tasks/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/environments/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataScans/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataTaxonomies/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataTaxonomies/*/attributes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataAttributeBindings/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryTypes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/aspectTypes/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/governanceRules/*}:getIamPolicy',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/zones/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/zones/*/assets/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/tasks/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/environments/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataScans/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataTaxonomies/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataTaxonomies/*/attributes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataAttributeBindings/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryTypes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/aspectTypes/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/governanceRules/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/zones/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/zones/*/assets/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/tasks/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/lakes/*/environments/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataScans/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataTaxonomies/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataTaxonomies/*/attributes/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataAttributeBindings/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryTypes/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/aspectTypes/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/governanceRules/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
    'numericEnums' => true,
];
