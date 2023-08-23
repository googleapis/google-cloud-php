<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlBackupRunsService' => [
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
                    [
                        'keyName' => 'id',
                        'fieldAccessors' => [
                            'getId',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Sql\V1\BackupRun',
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
                    [
                        'keyName' => 'id',
                        'fieldAccessors' => [
                            'getId',
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
                'responseType' => 'Google\Cloud\Sql\V1\BackupRunsListResponse',
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
