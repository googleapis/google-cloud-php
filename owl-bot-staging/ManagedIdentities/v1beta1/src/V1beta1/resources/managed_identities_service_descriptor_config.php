<?php

return [
    'interfaces' => [
        'google.cloud.managedidentities.v1beta1.ManagedIdentitiesService' => [
            'AttachTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateMicrosoftAdDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DetachTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReconfigureTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateDomain' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ValidateTrust' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\Domain',
                    'metadataReturnType' => '\Google\Cloud\ManagedIdentities\V1beta1\OpMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListDomains' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDomains',
                ],
            ],
        ],
    ],
];
