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
        'google.showcase.v1beta1.Compliance' => [
            'GetEnum' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/compliance/enum',
            ],
            'RepeatDataBody' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/repeat:body',
                'body' => '*',
            ],
            'RepeatDataBodyInfo' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/repeat:bodyinfo',
                'body' => 'info',
            ],
            'RepeatDataBodyPatch' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/repeat:bodypatch',
                'body' => '*',
            ],
            'RepeatDataBodyPut' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta1/repeat:bodyput',
                'body' => '*',
            ],
            'RepeatDataPathResource' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/repeat/{info.f_string=first/*}/{info.f_child.f_string=second/*}/bool/{info.f_bool}:pathresource',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/repeat/{info.f_child.f_string=first/*}/{info.f_string=second/*}/bool/{info.f_bool}:childfirstpathresource',
                    ],
                ],
                'placeholders' => [
                    'info.f_bool' => [
                        'getters' => [
                            'getInfo',
                            'getFBool',
                        ],
                    ],
                    'info.f_child.f_string' => [
                        'getters' => [
                            'getInfo',
                            'getFChild',
                            'getFString',
                        ],
                    ],
                    'info.f_string' => [
                        'getters' => [
                            'getInfo',
                            'getFString',
                        ],
                    ],
                ],
            ],
            'RepeatDataPathTrailingResource' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/repeat/{info.f_string=first/*}/{info.f_child.f_string=second/**}:pathtrailingresource',
                'placeholders' => [
                    'info.f_child.f_string' => [
                        'getters' => [
                            'getInfo',
                            'getFChild',
                            'getFString',
                        ],
                    ],
                    'info.f_string' => [
                        'getters' => [
                            'getInfo',
                            'getFString',
                        ],
                    ],
                ],
            ],
            'RepeatDataQuery' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/repeat:query',
            ],
            'RepeatDataSimplePath' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/repeat/{info.f_string}/{info.f_int32}/{info.f_double}/{info.f_bool}/{info.f_kingdom}:simplepath',
                'placeholders' => [
                    'info.f_bool' => [
                        'getters' => [
                            'getInfo',
                            'getFBool',
                        ],
                    ],
                    'info.f_double' => [
                        'getters' => [
                            'getInfo',
                            'getFDouble',
                        ],
                    ],
                    'info.f_int32' => [
                        'getters' => [
                            'getInfo',
                            'getFInt32',
                        ],
                    ],
                    'info.f_kingdom' => [
                        'getters' => [
                            'getInfo',
                            'getFKingdom',
                        ],
                    ],
                    'info.f_string' => [
                        'getters' => [
                            'getInfo',
                            'getFString',
                        ],
                    ],
                ],
            ],
            'VerifyEnum' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/compliance/enum',
            ],
        ],
    ],
];
