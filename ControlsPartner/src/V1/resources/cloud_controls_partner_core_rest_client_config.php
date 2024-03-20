<?php

return [
    'interfaces' => [
        'google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore' => [
            'GetCustomer' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/customers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEkmConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/customers/*/workloads/*/ekmConnections}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPartner' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/partner}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPartnerPermissions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/customers/*/workloads/*/partnerPermissions}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkload' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/customers/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAccessApprovalRequests' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*/customers/*/workloads/*}/accessApprovalRequests',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/customers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkloads' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*/customers/*}/workloads',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
