<?php

return [
    'interfaces' => [
        'google.cloud.functions.v2.FunctionService' => [
            'CreateFunction' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/functions',
                'body' => 'function',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteFunction' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/functions/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/functions/*}:generateDownloadUrl',
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
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/functions:generateUploadUrl',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/functions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListFunctions' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/functions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRuntimes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/runtimes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateFunction' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{function.name=projects/*/locations/*/functions/*}',
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
                'uriTemplate' => '/v2/{name=projects/*}/locations',
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
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/functions/*}:getIamPolicy',
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
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/functions/*}:setIamPolicy',
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
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/functions/*}:testIamPermissions',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
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
