<?php

return [
    'interfaces' => [
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
        'google.cloud.metastore.v1.DataprocMetastore' => [
            'CreateMetadataImport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/services/*}/metadataImports',
                'body' => 'metadata_import',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'metadata_import_id',
                ],
            ],
            'CreateService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/services',
                'body' => 'service',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'service_id',
                ],
            ],
            'DeleteService' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{service=projects/*/locations/*/services/*}:exportMetadata',
                'body' => '*',
                'placeholders' => [
                    'service' => [
                        'getters' => [
                            'getService',
                        ],
                    ],
                ],
            ],
            'GetMetadataImport' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/services/*/metadataImports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetService' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMetadataImports' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/services/*}/metadataImports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/services',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateMetadataImport' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{metadata_import.name=projects/*/locations/*/services/*/metadataImports/*}',
                'body' => 'metadata_import',
                'placeholders' => [
                    'metadata_import.name' => [
                        'getters' => [
                            'getMetadataImport',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateService' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service.name=projects/*/locations/*/services/*}',
                'body' => 'service',
                'placeholders' => [
                    'service.name' => [
                        'getters' => [
                            'getService',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/services/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/services/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/services/*}:testIamPermissions',
                'body' => '*',
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
];
