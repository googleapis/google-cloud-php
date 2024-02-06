<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.cx.v3.TestCases' => [
            'BatchDeleteTestCases' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*}/testCases:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchRunTestCases' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*}/testCases:batchRun',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CalculateCoverage' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{agent=projects/*/locations/*/agents/*}/testCases:calculateCoverage',
                'placeholders' => [
                    'agent' => [
                        'getters' => [
                            'getAgent',
                        ],
                    ],
                ],
            ],
            'CreateTestCase' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*}/testCases',
                'body' => 'test_case',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ExportTestCases' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*}/testCases:export',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTestCase' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*/testCases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTestCaseResult' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*/testCases/*/results/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportTestCases' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*}/testCases:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTestCaseResults' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*/testCases/*}/results',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTestCases' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/agents/*}/testCases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunTestCase' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*/testCases/*}:run',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTestCase' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{test_case.name=projects/*/locations/*/agents/*/testCases/*}',
                'body' => 'test_case',
                'placeholders' => [
                    'test_case.name' => [
                        'getters' => [
                            'getTestCase',
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
                'uriTemplate' => '/v3/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*}/locations',
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
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:cancel',
                    ],
                ],
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
                'uriTemplate' => '/v3/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
                    ],
                ],
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
                'uriTemplate' => '/v3/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*}/operations',
                    ],
                ],
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
