<?php

return [
    'interfaces' => [
        'google.cloud.accessapproval.v1.AccessApproval' => [
            'ApproveApprovalRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/approvalRequests/*}:approve',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/approvalRequests/*}:approve',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/approvalRequests/*}:approve',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAccessApprovalSettings' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/accessApprovalSettings}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/accessApprovalSettings}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/accessApprovalSettings}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DismissApprovalRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/approvalRequests/*}:dismiss',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/approvalRequests/*}:dismiss',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/approvalRequests/*}:dismiss',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccessApprovalServiceAccount' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/serviceAccount}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/serviceAccount}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/serviceAccount}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccessApprovalSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/accessApprovalSettings}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/accessApprovalSettings}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/accessApprovalSettings}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApprovalRequest' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/approvalRequests/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/approvalRequests/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/approvalRequests/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InvalidateApprovalRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/approvalRequests/*}:invalidate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/approvalRequests/*}:invalidate',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/approvalRequests/*}:invalidate',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApprovalRequests' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/approvalRequests',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/approvalRequests',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*}/approvalRequests',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAccessApprovalSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{settings.name=projects/*/accessApprovalSettings}',
                'body' => 'settings',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{settings.name=folders/*/accessApprovalSettings}',
                        'body' => 'settings',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{settings.name=organizations/*/accessApprovalSettings}',
                        'body' => 'settings',
                    ],
                ],
                'placeholders' => [
                    'settings.name' => [
                        'getters' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
