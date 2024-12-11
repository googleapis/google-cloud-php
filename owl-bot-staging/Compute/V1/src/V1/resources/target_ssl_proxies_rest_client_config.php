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
        'google.cloud.compute.v1.TargetSslProxies' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies',
                'body' => 'target_ssl_proxy_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SetBackendService' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setBackendService',
                'body' => 'target_ssl_proxies_set_backend_service_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetCertificateMap' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setCertificateMap',
                'body' => 'target_ssl_proxies_set_certificate_map_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetProxyHeader' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setProxyHeader',
                'body' => 'target_ssl_proxies_set_proxy_header_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetSslCertificates' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setSslCertificates',
                'body' => 'target_ssl_proxies_set_ssl_certificates_request_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
            'SetSslPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/targetSslProxies/{target_ssl_proxy}/setSslPolicy',
                'body' => 'ssl_policy_reference_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'target_ssl_proxy' => [
                        'getters' => [
                            'getTargetSslProxy',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.compute.v1.GlobalOperations' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}/wait',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
