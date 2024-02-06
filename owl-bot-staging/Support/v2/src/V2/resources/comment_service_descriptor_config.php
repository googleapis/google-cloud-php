<?php

return [
    'interfaces' => [
        'google.cloud.support.v2.CommentService' => [
            'CreateComment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Support\V2\Comment',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListComments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getComments',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Support\V2\ListCommentsResponse',
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
                'case' => 'organizations/{organization}/cases/{case}',
                'comment' => 'organizations/{organization}/cases/{case}/comments/{comment}',
                'organizationCase' => 'organizations/{organization}/cases/{case}',
                'organizationCaseComment' => 'organizations/{organization}/cases/{case}/comments/{comment}',
                'projectCase' => 'projects/{project}/cases/{case}',
                'projectCaseComment' => 'projects/{project}/cases/{case}/comments/{comment}',
            ],
        ],
    ],
];
