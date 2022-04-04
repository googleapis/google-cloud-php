<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.TagKeys' => [
            'CreateTagKey' => [
                'method' => 'post',
                'uriTemplate' => '/v3/tagKeys',
                'body' => 'tag_key',
            ],
            'DeleteTagKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=tagKeys/*}',
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
                'uriTemplate' => '/v3/{resource=tagKeys/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetTagKey' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=tagKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTagKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagKeys',
                'queryParams' => [
                    'parent',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=tagKeys/*}:setIamPolicy',
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
                'uriTemplate' => '/v3/{resource=tagKeys/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateTagKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{tag_key.name=tagKeys/*}',
                'body' => 'tag_key',
                'placeholders' => [
                    'tag_key.name' => [
                        'getters' => [
                            'getTagKey',
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
