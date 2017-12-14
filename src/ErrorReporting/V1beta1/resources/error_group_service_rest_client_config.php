<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ErrorGroupService' => [
            'GetGroup' => [
                'method' => 'get',
                'uri' => '/v1beta1/{group_name=projects/*/groups/*}',
                'placeholders' => [
                    'group_name' => [
                        'getGroup_name',
                    ],
                ],
            ],
            'UpdateGroup' => [
                'method' => 'put',
                'uri' => '/v1beta1/{group.name=projects/*/groups/*}',
                'body' => 'group',
                'placeholders' => [
                    'group.name' => [
                        'getGroup',
                        'getName',
                    ],
                ],
            ],
        ],
    ],
];
