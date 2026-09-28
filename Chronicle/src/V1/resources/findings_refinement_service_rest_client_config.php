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
        'google.cloud.chronicle.v1.FindingsRefinementService' => [
            'ComputeAllFindingsRefinementActivities' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{instance=projects/*/locations/*/instances/*}:computeAllFindingsRefinementActivities',
                'body' => '*',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'ComputeFindingsRefinementActivity' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/findingsRefinements/*}:computeFindingsRefinementActivity',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateFindingsRefinement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/findingsRefinements',
                'body' => 'findings_refinement',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetFindingsRefinement' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/findingsRefinements/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFindingsRefinementDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/findingsRefinements/*/deployment}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAllFindingsRefinementDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{instance=projects/*/locations/*/instances/*}:listAllFindingsRefinementDeployments',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'ListFindingsRefinements' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/findingsRefinements',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateFindingsRefinement' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{findings_refinement.name=projects/*/locations/*/instances/*/findingsRefinements/*}',
                'body' => 'findings_refinement',
                'placeholders' => [
                    'findings_refinement.name' => [
                        'getters' => [
                            'getFindingsRefinement',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFindingsRefinementDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{findings_refinement_deployment.name=projects/*/locations/*/instances/*/findingsRefinements/*/deployment}',
                'body' => 'findings_refinement_deployment',
                'placeholders' => [
                    'findings_refinement_deployment.name' => [
                        'getters' => [
                            'getFindingsRefinementDeployment',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}/operations',
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
