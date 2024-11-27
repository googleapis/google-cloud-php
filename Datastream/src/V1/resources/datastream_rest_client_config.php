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
        'google.cloud.datastream.v1.Datastream' => [
            'CreateConnectionProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectionProfiles',
                'body' => 'connection_profile',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'connection_profile_id',
                ],
            ],
            'CreatePrivateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateConnections',
                'body' => 'private_connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'private_connection_id',
                ],
            ],
            'CreateRoute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateConnections/*}/routes',
                'body' => 'route',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'route_id',
                ],
            ],
            'CreateStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/streams',
                'body' => 'stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'stream_id',
                ],
            ],
            'DeleteConnectionProfile' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connectionProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePrivateConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRoute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*/routes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteStream' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/streams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DiscoverConnectionProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectionProfiles:discover',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'FetchStaticIps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}:fetchStaticIps',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConnectionProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connectionProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPrivateConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRoute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*/routes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/streams/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetStreamObject' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/streams/*/objects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConnectionProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectionProfiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPrivateConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateConnections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/privateConnections/*}/routes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListStreamObjects' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/streams/*}/objects',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/streams',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupStreamObject' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/streams/*}/objects:lookup',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/streams/*}:run',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StartBackfillJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{object=projects/*/locations/*/streams/*/objects/*}:startBackfillJob',
                'body' => '*',
                'placeholders' => [
                    'object' => [
                        'getters' => [
                            'getObject',
                        ],
                    ],
                ],
            ],
            'StopBackfillJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{object=projects/*/locations/*/streams/*/objects/*}:stopBackfillJob',
                'body' => '*',
                'placeholders' => [
                    'object' => [
                        'getters' => [
                            'getObject',
                        ],
                    ],
                ],
            ],
            'UpdateConnectionProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{connection_profile.name=projects/*/locations/*/connectionProfiles/*}',
                'body' => 'connection_profile',
                'placeholders' => [
                    'connection_profile.name' => [
                        'getters' => [
                            'getConnectionProfile',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateStream' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{stream.name=projects/*/locations/*/streams/*}',
                'body' => 'stream',
                'placeholders' => [
                    'stream.name' => [
                        'getters' => [
                            'getStream',
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
