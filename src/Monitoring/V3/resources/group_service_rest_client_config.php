<?php

return [
    'interfaces' => [
        'google.monitoring.v3.GroupService' => [
            'ListGroups' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*}/groups',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GetGroup' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateGroup' => [
                'method' => 'post',
                'uri' => '/v3/{name=projects/*}/groups',
                'body' => 'group',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'UpdateGroup' => [
                'method' => 'put',
                'uri' => '/v3/{group.name=projects/*/groups/*}',
                'body' => 'group',
                'placeholders' => [
                    'group.name' => [
                        'getGroup',
                        'getName',
                    ],
                ],
            ],
            'DeleteGroup' => [
                'method' => 'delete',
                'uri' => '/v3/{name=projects/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListGroupMembers' => [
                'method' => 'get',
                'uri' => '/v3/{name=projects/*/groups/*}/members',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
        ],
    ],
];
