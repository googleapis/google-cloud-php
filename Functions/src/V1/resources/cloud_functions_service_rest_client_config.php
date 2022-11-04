<?php

return [
    'interfaces' => [
        'google.cloud.functions.v1.CloudFunctionsService' => [
            'CallFunction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/functions/*}:call',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateFunction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{location=projects/*/locations/*}/functions',
                'body' => 'function',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'DeleteFunction' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/functions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateDownloadUrl' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/functions/*}:generateDownloadUrl',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateUploadUrl' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/functions:generateUploadUrl',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetFunction' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/functions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/functions/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'ListFunctions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/functions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/functions/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/functions/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateFunction' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{function.name=projects/*/locations/*/functions/*}',
                'body' => 'function',
                'placeholders' => [
                    'function.name' => [
                        'getters' => [
                            'getFunction',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
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
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=operations/*}',
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
                'uriTemplate' => '/v1/operations',
            ],
        ],
    ],
];
