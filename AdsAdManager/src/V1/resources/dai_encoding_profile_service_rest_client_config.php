<?php
/*
 * Copyright 2026 Google LLC
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
        'google.ads.admanager.v1.DaiEncodingProfileService' => [
            'BatchActivateDaiEncodingProfiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiEncodingProfiles:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchiveDaiEncodingProfiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiEncodingProfiles:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateDaiEncodingProfiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiEncodingProfiles:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateDaiEncodingProfiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiEncodingProfiles:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDaiEncodingProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/daiEncodingProfiles',
                'body' => 'dai_encoding_profile',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetDaiEncodingProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/daiEncodingProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDaiEncodingProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/daiEncodingProfiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDaiEncodingProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dai_encoding_profile.name=networks/*/daiEncodingProfiles/*}',
                'body' => 'dai_encoding_profile',
                'placeholders' => [
                    'dai_encoding_profile.name' => [
                        'getters' => [
                            'getDaiEncodingProfile',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
