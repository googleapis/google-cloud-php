<?php

return [
    'interfaces' => [
        'google.monitoring.v3.GroupService' => [
            'CreateGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/groups',
                'body' => 'group',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGroupMembers' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/groups/*}/members',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/groups',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGroup' => [
                'method' => 'put',
                'uriTemplate' => '/v3/{group.name=projects/*/groups/*}',
                'body' => 'group',
                'placeholders' => [
                    'group.name' => [
                        'getters' => [
                            'getGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
