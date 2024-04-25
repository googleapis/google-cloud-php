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
        'google.cloud.retail.v2.CatalogService' => [
            'AddCatalogAttribute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'GetAttributesConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCompletionConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\CompletionConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDefaultBranch' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\GetDefaultBranchResponse',
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'ListCatalogs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCatalogs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ListCatalogsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveCatalogAttribute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'ReplaceCatalogAttribute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'SetDefaultBranch' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'UpdateAttributesConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\AttributesConfig',
                'headerParams' => [
                    [
                        'keyName' => 'attributes_config.name',
                        'fieldAccessors' => [
                            'getAttributesConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCatalog' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\Catalog',
                'headerParams' => [
                    [
                        'keyName' => 'catalog.name',
                        'fieldAccessors' => [
                            'getCatalog',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCompletionConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\CompletionConfig',
                'headerParams' => [
                    [
                        'keyName' => 'completion_config.name',
                        'fieldAccessors' => [
                            'getCompletionConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'attributesConfig' => 'projects/{project}/locations/{location}/catalogs/{catalog}/attributesConfig',
                'branch' => 'projects/{project}/locations/{location}/catalogs/{catalog}/branches/{branch}',
                'catalog' => 'projects/{project}/locations/{location}/catalogs/{catalog}',
                'completionConfig' => 'projects/{project}/locations/{location}/catalogs/{catalog}/completionConfig',
                'location' => 'projects/{project}/locations/{location}',
            ],
        ],
    ],
];
