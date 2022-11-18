<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.Organizations' => [
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=organizations/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetOrganization' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=organizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchOrganizations' => [
                'method' => 'get',
                'uriTemplate' => '/v3/organizations:search',
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=organizations/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=organizations/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=operations/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
