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
        'google.ads.admanager.v1.SiteService' => [
            'BatchCreateSites' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/sites:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateSites' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/sites:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchSubmitSitesForApproval' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/sites:batchSubmitForApproval',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateSites' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/sites:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSite' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/sites',
                'body' => 'site',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSite' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/sites/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSites' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/sites',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSite' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{site.name=networks/*/sites/*}',
                'body' => 'site',
                'placeholders' => [
                    'site.name' => [
                        'getters' => [
                            'getSite',
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
