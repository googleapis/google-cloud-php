<?php

return [
    'interfaces' => [
        'google.cloud.security.privateca.v1.CertificateAuthorityService' => [
            'ActivateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCaPool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CaPool',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCertificateTemplate' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateTemplate',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteCaPool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteCertificateTemplate' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DisableCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'EnableCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeleteCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCaPool' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CaPool',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateRevocationList' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateRevocationList',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateTemplate' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1\CertificateTemplate',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListCaPools' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCaPools',
                ],
            ],
            'ListCertificateAuthorities' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificateAuthorities',
                ],
            ],
            'ListCertificateRevocationLists' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificateRevocationLists',
                ],
            ],
            'ListCertificateTemplates' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificateTemplates',
                ],
            ],
            'ListCertificates' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCertificates',
                ],
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
            ],
        ],
    ],
];
