<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ErrorGroupService' => [
            'GetGroup' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ErrorGroup',
                'headerParams' => [
                    [
                        'keyName' => 'group_name',
                        'fieldAccessors' => [
                            'getGroupName',
                        ],
                    ],
                ],
            ],
            'UpdateGroup' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ErrorGroup',
                'headerParams' => [
                    [
                        'keyName' => 'group.name',
                        'fieldAccessors' => [
                            'getGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'errorGroup' => 'projects/{project}/groups/{group}',
            ],
        ],
    ],
];
