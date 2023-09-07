<?php

return [
    'interfaces' => [
        'google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1' => [
            'CreateAttestor' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\Attestor',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAttestor' => [
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
            'GetAttestor' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\Attestor',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAttestors' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAttestors',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\ListAttestorsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAttestor' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\Attestor',
                'headerParams' => [
                    [
                        'keyName' => 'attestor.name',
                        'fieldAccessors' => [
                            'getAttestor',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'policy.name',
                        'fieldAccessors' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'attestor' => 'projects/{project}/attestors/{attestor}',
                'locationPolicy' => 'locations/{location}/policy',
                'policy' => 'projects/{project}/policy',
                'project' => 'projects/{project}',
                'projectPolicy' => 'projects/{project}/policy',
            ],
        ],
    ],
];
