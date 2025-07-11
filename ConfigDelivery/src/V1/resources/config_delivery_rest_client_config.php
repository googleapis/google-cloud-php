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
        'google.cloud.configdelivery.v1.ConfigDelivery' => [
            'AbortRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleetPackages/*/rollouts/*}:abort',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateFleetPackage' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/fleetPackages',
                'body' => 'fleet_package',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'fleet_package_id',
                ],
            ],
            'CreateRelease' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/resourceBundles/*}/releases',
                'body' => 'release',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'release_id',
                ],
            ],
            'CreateResourceBundle' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/resourceBundles',
                'body' => 'resource_bundle',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'resource_bundle_id',
                ],
            ],
            'CreateVariant' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/resourceBundles/*/releases/*}/variants',
                'body' => 'variant',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'variant_id',
                ],
            ],
            'DeleteFleetPackage' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleetPackages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRelease' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/resourceBundles/*/releases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteResourceBundle' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/resourceBundles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVariant' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/resourceBundles/*/releases/*/variants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFleetPackage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleetPackages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRelease' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/resourceBundles/*/releases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetResourceBundle' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/resourceBundles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRollout' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleetPackages/*/rollouts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVariant' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/resourceBundles/*/releases/*/variants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListFleetPackages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/fleetPackages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReleases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/resourceBundles/*}/releases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListResourceBundles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/resourceBundles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRollouts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/fleetPackages/*}/rollouts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVariants' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/resourceBundles/*/releases/*}/variants',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResumeRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleetPackages/*/rollouts/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SuspendRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/fleetPackages/*/rollouts/*}:suspend',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFleetPackage' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{fleet_package.name=projects/*/locations/*/fleetPackages/*}',
                'body' => 'fleet_package',
                'placeholders' => [
                    'fleet_package.name' => [
                        'getters' => [
                            'getFleetPackage',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateRelease' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{release.name=projects/*/locations/*/resourceBundles/*/releases/*}',
                'body' => 'release',
                'placeholders' => [
                    'release.name' => [
                        'getters' => [
                            'getRelease',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateResourceBundle' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{resource_bundle.name=projects/*/locations/*/resourceBundles/*}',
                'body' => 'resource_bundle',
                'placeholders' => [
                    'resource_bundle.name' => [
                        'getters' => [
                            'getResourceBundle',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateVariant' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{variant.name=projects/*/locations/*/resourceBundles/*/releases/*/variants/*}',
                'body' => 'variant',
                'placeholders' => [
                    'variant.name' => [
                        'getters' => [
                            'getVariant',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/locations',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
