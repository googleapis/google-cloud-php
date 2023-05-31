<?php

return [
    'interfaces' => [
        'google.cloud.accessapproval.v1.AccessApproval' => [
            'ApproveApprovalRequest' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\ApprovalRequest',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAccessApprovalSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DismissApprovalRequest' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\ApprovalRequest',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccessApprovalServiceAccount' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\AccessApprovalServiceAccount',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccessApprovalSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\AccessApprovalSettings',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApprovalRequest' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\ApprovalRequest',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InvalidateApprovalRequest' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\ApprovalRequest',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApprovalRequests' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getApprovalRequests',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\ListApprovalRequestsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAccessApprovalSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AccessApproval\V1\AccessApprovalSettings',
                'headerParams' => [
                    [
                        'keyName' => 'settings.name',
                        'fieldAccessors' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'accessApprovalSettings' => 'projects/{project}/accessApprovalSettings',
                'approvalRequest' => 'projects/{project}/approvalRequests/{approval_request}',
                'folder' => 'folders/{folder}',
                'folderAccessApprovalSettings' => 'folders/{folder}/accessApprovalSettings',
                'folderApprovalRequest' => 'folders/{folder}/approvalRequests/{approval_request}',
                'organization' => 'organizations/{organization}',
                'organizationAccessApprovalSettings' => 'organizations/{organization}/accessApprovalSettings',
                'organizationApprovalRequest' => 'organizations/{organization}/approvalRequests/{approval_request}',
                'project' => 'projects/{project}',
                'projectAccessApprovalSettings' => 'projects/{project}/accessApprovalSettings',
                'projectApprovalRequest' => 'projects/{project}/approvalRequests/{approval_request}',
            ],
        ],
    ],
];
