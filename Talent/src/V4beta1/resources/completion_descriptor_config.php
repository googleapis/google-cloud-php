<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.Completion' => [
            'CompleteQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Talent\V4beta1\CompleteQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'company' => 'projects/{project}/tenants/{tenant}/companies/{company}',
                'project' => 'projects/{project}',
                'projectCompany' => 'projects/{project}/companies/{company}',
                'projectTenantCompany' => 'projects/{project}/tenants/{tenant}/companies/{company}',
                'tenant' => 'projects/{project}/tenants/{tenant}',
            ],
        ],
    ],
];
