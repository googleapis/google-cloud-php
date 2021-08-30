<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.TagBindings' => [
            'CreateTagBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v3/tagBindings',
                'body' => 'tag_binding',
            ],
            'DeleteTagBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=tagBindings/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTagBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagBindings',
                'queryParams' => [
                    'parent',
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
