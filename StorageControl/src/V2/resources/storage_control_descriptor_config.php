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
            'templateMap' => [
                'bucket' => 'projects/{project}/buckets/{bucket}',
                'folder' => 'projects/{project}/buckets/{bucket}/folders/{folder=**}',
                'managedFolder' => 'projects/{project}/buckets/{bucket}/managedFolders/{managed_folder=**}',
                'storageLayout' => 'projects/{project}/buckets/{bucket}/storageLayout',
            ],
        ],
    ],
];
