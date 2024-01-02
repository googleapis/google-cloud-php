<?php

return [
    'interfaces' => [
        'google.cloud.security.privateca.v1beta1.CertificateAuthorityService' => [
            'ActivateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DisableCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'EnableCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RestoreCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ScheduleDeleteCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateAuthority' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCertificateRevocationList' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\CertificateRevocationList',
                    'metadataReturnType' => '\Google\Cloud\Security\PrivateCA\V1beta1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
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
            'ListReusableConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getReusableConfigs',
                ],
            ],
        ],
    ],
];
