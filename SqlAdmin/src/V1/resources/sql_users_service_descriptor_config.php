<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlUsersService' => [
            'Delete' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Sql\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Sql\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'List' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Sql\V1\UsersListResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Update' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Sql\V1\Operation',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
