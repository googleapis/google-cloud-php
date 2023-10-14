<?php

return [
    'interfaces' => [
        'google.cloud.support.v2.CaseAttachmentService' => [
            'ListAttachments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAttachments',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Support\V2\ListAttachmentsResponse',
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
                'organizationCase' => 'organizations/{organization}/cases/{case}',
                'projectCase' => 'projects/{project}/cases/{case}',
            ],
        ],
    ],
];
