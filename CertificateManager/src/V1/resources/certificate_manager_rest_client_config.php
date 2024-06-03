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
        'google.cloud.certificatemanager.v1.CertificateManager' => [
            'CreateCertificate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificates',
                'body' => 'certificate',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_id',
                ],
            ],
            'CreateCertificateIssuanceConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateIssuanceConfigs',
                'body' => 'certificate_issuance_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_issuance_config_id',
                ],
            ],
            'CreateCertificateMap' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateMaps',
                'body' => 'certificate_map',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_map_id',
                ],
            ],
            'CreateCertificateMapEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/certificateMaps/*}/certificateMapEntries',
                'body' => 'certificate_map_entry',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'certificate_map_entry_id',
                ],
            ],
            'CreateDnsAuthorization' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dnsAuthorizations',
                'body' => 'dns_authorization',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'dns_authorization_id',
                ],
            ],
            'CreateTrustConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/trustConfigs',
                'body' => 'trust_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'trust_config_id',
                ],
            ],
            'DeleteCertificate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCertificateIssuanceConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateIssuanceConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCertificateMap' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCertificateMapEntry' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*/certificateMapEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDnsAuthorization' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsAuthorizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTrustConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/trustConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateIssuanceConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateIssuanceConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateMap' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCertificateMapEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/certificateMaps/*/certificateMapEntries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDnsAuthorization' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dnsAuthorizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTrustConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/trustConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCertificateIssuanceConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateIssuanceConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCertificateMapEntries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/certificateMaps/*}/certificateMapEntries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCertificateMaps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificateMaps',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCertificates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/certificates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDnsAuthorizations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dnsAuthorizations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTrustConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/trustConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCertificate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{certificate.name=projects/*/locations/*/certificates/*}',
                'body' => 'certificate',
                'placeholders' => [
                    'certificate.name' => [
                        'getters' => [
                            'getCertificate',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCertificateMap' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{certificate_map.name=projects/*/locations/*/certificateMaps/*}',
                'body' => 'certificate_map',
                'placeholders' => [
                    'certificate_map.name' => [
                        'getters' => [
                            'getCertificateMap',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateCertificateMapEntry' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{certificate_map_entry.name=projects/*/locations/*/certificateMaps/*/certificateMapEntries/*}',
                'body' => 'certificate_map_entry',
                'placeholders' => [
                    'certificate_map_entry.name' => [
                        'getters' => [
                            'getCertificateMapEntry',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDnsAuthorization' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dns_authorization.name=projects/*/locations/*/dnsAuthorizations/*}',
                'body' => 'dns_authorization',
                'placeholders' => [
                    'dns_authorization.name' => [
                        'getters' => [
                            'getDnsAuthorization',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTrustConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{trust_config.name=projects/*/locations/*/trustConfigs/*}',
                'body' => 'trust_config',
                'placeholders' => [
                    'trust_config.name' => [
                        'getters' => [
                            'getTrustConfig',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
