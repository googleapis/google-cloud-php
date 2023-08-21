<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.Completion' => [
            'CompleteQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Talent\V4\CompleteQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'tenant',
                        'fieldAccessors' => [
                            'getTenant',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'company' => 'projects/{project}/tenants/{tenant}/companies/{company}',
                'tenant' => 'projects/{project}/tenants/{tenant}',
            ],
        ],
    ],
];
