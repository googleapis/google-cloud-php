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
        'google.showcase.v1beta1.Compliance' => [
            'GetEnum' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EnumResponse',
            ],
            'RepeatDataBody' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
            ],
            'RepeatDataBodyInfo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
            ],
            'RepeatDataBodyPatch' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
            ],
            'RepeatDataBodyPut' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
            ],
            'RepeatDataPathResource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
                'headerParams' => [
                    [
                        'keyName' => 'info.f_child.f_string',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFChild',
                            'getFString',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_string',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFString',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_bool',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFBool',
                        ],
                    ],
                ],
            ],
            'RepeatDataPathTrailingResource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
                'headerParams' => [
                    [
                        'keyName' => 'info.f_string',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFString',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_child.f_string',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFChild',
                            'getFString',
                        ],
                    ],
                ],
            ],
            'RepeatDataQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
            ],
            'RepeatDataSimplePath' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\RepeatResponse',
                'headerParams' => [
                    [
                        'keyName' => 'info.f_string',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFString',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_int32',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFInt32',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_double',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFDouble',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_bool',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFBool',
                        ],
                    ],
                    [
                        'keyName' => 'info.f_kingdom',
                        'fieldAccessors' => [
                            'getInfo',
                            'getFKingdom',
                        ],
                    ],
                ],
            ],
            'VerifyEnum' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Showcase\V1beta1\EnumResponse',
            ],
        ],
    ],
];
