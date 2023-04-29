<?php

return [
    'interfaces' => [
        'google.cloud.support.v2.CommentService' => [
            'CreateComment' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/cases/*}/comments',
                'body' => 'comment',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*/cases/*}/comments',
                        'body' => 'comment',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListComments' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/cases/*}/comments',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/cases/*}/comments',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
