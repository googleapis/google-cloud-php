<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

return [
    'interfaces' => [
        'google.storage.control.v2.StorageControl' => [
            'CreateAnywhereCache' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Storage\Control\V2\AnywhereCache',
                    'metadataReturnType' => '\Google\Cloud\Storage\Control\V2\CreateAnywhereCacheMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'RenameFolder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Storage\Control\V2\Folder',
                    'metadataReturnType' => '\Google\Cloud\Storage\Control\V2\RenameFolderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'UpdateAnywhereCache' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Storage\Control\V2\AnywhereCache',
                    'metadataReturnType' => '\Google\Cloud\Storage\Control\V2\UpdateAnywhereCacheMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getAnywhereCache',
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'CreateFolder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\Folder',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'CreateManagedFolder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\ManagedFolder',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'DeleteFolder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'DeleteManagedFolder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'DisableAnywhereCache' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\AnywhereCache',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'GetAnywhereCache' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\AnywhereCache',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'GetFolder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\Folder',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'GetFolderIntelligenceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\IntelligenceConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetManagedFolder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\ManagedFolder',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'GetOrganizationIntelligenceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\IntelligenceConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProjectIntelligenceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\IntelligenceConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetStorageLayout' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\StorageLayout',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'ListAnywhereCaches' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAnywhereCaches',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\ListAnywhereCachesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'ListFolders' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFolders',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\ListFoldersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListManagedFolders' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getManagedFolders',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\ListManagedFoldersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'PauseAnywhereCache' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\AnywhereCache',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'ResumeAnywhereCache' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\AnywhereCache',
                'headerParams' => [
                    [
                        'keyName' => 'bucket',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<bucket>projects\/[^\/]+\/buckets\/[^\/]+)(?:\/.*)?$/',
                        ],
                    ],
                ],
                'autoPopulatedFields' => [
                    'requestId' => \Google\Api\FieldInfo\Format::UUID4,
                ],
            ],
            'UpdateFolderIntelligenceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\IntelligenceConfig',
                'headerParams' => [
                    [
                        'keyName' => 'intelligence_config.name',
                        'fieldAccessors' => [
                            'getIntelligenceConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateOrganizationIntelligenceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\IntelligenceConfig',
                'headerParams' => [
                    [
                        'keyName' => 'intelligence_config.name',
                        'fieldAccessors' => [
                            'getIntelligenceConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProjectIntelligenceConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Storage\Control\V2\IntelligenceConfig',
                'headerParams' => [
                    [
                        'keyName' => 'intelligence_config.name',
                        'fieldAccessors' => [
                            'getIntelligenceConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'anywhereCache' => 'projects/{project}/buckets/{bucket}/anywhereCaches/{anywhere_cache}',
                'bucket' => 'projects/{project}/buckets/{bucket}',
                'folder' => 'projects/{project}/buckets/{bucket}/folders/{folder=**}',
                'folderLocationIntelligenceConfig' => 'folders/{folder}/locations/{location}/intelligenceConfig',
                'intelligenceConfig' => 'folders/{folder}/locations/{location}/intelligenceConfig',
                'managedFolder' => 'projects/{project}/buckets/{bucket}/managedFolders/{managed_folder=**}',
                'orgLocationIntelligenceConfig' => 'organizations/{org}/locations/{location}/intelligenceConfig',
                'projectLocationIntelligenceConfig' => 'projects/{project}/locations/{location}/intelligenceConfig',
                'storageLayout' => 'projects/{project}/buckets/{bucket}/storageLayout',
            ],
        ],
    ],
];
