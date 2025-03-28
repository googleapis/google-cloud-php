<?php
/*
 * Copyright 2025 Google LLC
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
        'google.api.cloudquotas.v1beta.CloudQuotas' => [
            'CreateQuotaPreference' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/quotaPreferences',
                'body' => 'quota_preference',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/quotaPreferences',
                        'body' => 'quota_preference',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/quotaPreferences',
                        'body' => 'quota_preference',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetQuotaInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/services/*/quotaInfos/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/services/*/quotaInfos/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=folders/*/locations/*/services/*/quotaInfos/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQuotaPreference' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/quotaPreferences/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/quotaPreferences/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=folders/*/locations/*/quotaPreferences/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListQuotaInfos' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/services/*}/quotaInfos',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*/services/*}/quotaInfos',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*/services/*}/quotaInfos',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQuotaPreferences' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*}/quotaPreferences',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=folders/*/locations/*}/quotaPreferences',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/quotaPreferences',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateQuotaPreference' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{quota_preference.name=projects/*/locations/*/quotaPreferences/*}',
                'body' => 'quota_preference',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{quota_preference.name=folders/*/locations/*/quotaPreferences/*}',
                        'body' => 'quota_preference',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{quota_preference.name=organizations/*/locations/*/quotaPreferences/*}',
                        'body' => 'quota_preference',
                    ],
                ],
                'placeholders' => [
                    'quota_preference.name' => [
                        'getters' => [
                            'getQuotaPreference',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
