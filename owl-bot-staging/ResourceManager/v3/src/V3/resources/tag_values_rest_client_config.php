<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.TagValues' => [
            'CreateTagValue' => [
                'method' => 'post',
                'uriTemplate' => '/v3/tagValues',
                'body' => 'tag_value',
            ],
            'DeleteTagValue' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=tagValues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=tagValues/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetTagValue' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=tagValues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTagValues' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagValues',
                'queryParams' => [
                    'parent',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=tagValues/*}:setIamPolicy',
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
                'uriTemplate' => '/v3/{resource=tagValues/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateTagValue' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{tag_value.name=tagValues/*}',
                'body' => 'tag_value',
                'placeholders' => [
                    'tag_value.name' => [
                        'getters' => [
                            'getTagValue',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=operations/**}',
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
