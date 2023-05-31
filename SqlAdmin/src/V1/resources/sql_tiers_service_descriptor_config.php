<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlTiersService' => [
            'List' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Sql\V1\TiersListResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
