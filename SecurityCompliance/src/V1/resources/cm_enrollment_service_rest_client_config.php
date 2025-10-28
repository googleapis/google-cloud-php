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
        'google.cloud.cloudsecuritycompliance.v1.CmEnrollmentService' => [
            'CalculateEffectiveCmEnrollment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/cmEnrollment}:calculate',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/cmEnrollment}:calculate',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/cmEnrollment}:calculate',
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
            'UpdateCmEnrollment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{cm_enrollment.name=organizations/*/locations/*/cmEnrollment}',
                'body' => 'cm_enrollment',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{cm_enrollment.name=folders/*/locations/*/cmEnrollment}',
                        'body' => 'cm_enrollment',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{cm_enrollment.name=projects/*/locations/*/cmEnrollment}',
                        'body' => 'cm_enrollment',
                    ],
                ],
                'placeholders' => [
                    'cm_enrollment.name' => [
                        'getters' => [
                            'getCmEnrollment',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*}/operations',
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
