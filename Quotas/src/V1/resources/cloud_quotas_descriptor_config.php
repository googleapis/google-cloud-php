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
        'google.api.cloudquotas.v1.CloudQuotas' => [
            'CreateQuotaPreference' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaPreference',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetQuotaInfo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaInfo',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQuotaPreference' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaPreference',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListQuotaInfos' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getQuotaInfos',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\ListQuotaInfosResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQuotaPreferences' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getQuotaPreferences',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\ListQuotaPreferencesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateQuotaPreference' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\CloudQuotas\V1\QuotaPreference',
                'headerParams' => [
                    [
                        'keyName' => 'quota_preference.name',
                        'fieldAccessors' => [
                            'getQuotaPreference',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'folderLocation' => 'folders/{folder}/locations/{location}',
                'folderLocationQuotaPreference' => 'folders/{folder}/locations/{location}/quotaPreferences/{quota_preference}',
                'folderLocationService' => 'folders/{folder}/locations/{location}/services/{service}',
                'folderLocationServiceQuotaInfo' => 'folders/{folder}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'location' => 'projects/{project}/locations/{location}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationLocationQuotaPreference' => 'organizations/{organization}/locations/{location}/quotaPreferences/{quota_preference}',
                'organizationLocationService' => 'organizations/{organization}/locations/{location}/services/{service}',
                'organizationLocationServiceQuotaInfo' => 'organizations/{organization}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'projectLocation' => 'projects/{project}/locations/{location}',
                'projectLocationQuotaPreference' => 'projects/{project}/locations/{location}/quotaPreferences/{quota_preference}',
                'projectLocationService' => 'projects/{project}/locations/{location}/services/{service}',
                'projectLocationServiceQuotaInfo' => 'projects/{project}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'quotaInfo' => 'projects/{project}/locations/{location}/services/{service}/quotaInfos/{quota_info}',
                'quotaPreference' => 'projects/{project}/locations/{location}/quotaPreferences/{quota_preference}',
                'service' => 'projects/{project}/locations/{location}/services/{service}',
            ],
        ],
    ],
];
