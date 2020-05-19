<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ErrorGroupService' => [
            'UpdateGroup' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta1/{group.name=projects/*/groups/*}',
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
            'GetGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{group_name=projects/*/groups/*}',
                'placeholders' => [
                    'group_name' => [
                        'getters' => [
                            'getGroupName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
