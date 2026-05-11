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
        'google.ads.admanager.v1.TeamService' => [
            'BatchActivateTeams' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchActivateTeamsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateTeams' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchCreateTeamsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivateTeams' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchDeactivateTeamsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateTeams' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\BatchUpdateTeamsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTeam' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Team',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetTeam' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Team',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTeams' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTeams',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\ListTeamsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateTeam' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Ads\AdManager\V1\Team',
                'headerParams' => [
                    [
                        'keyName' => 'team.name',
                        'fieldAccessors' => [
                            'getTeam',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'network' => 'networks/{network_code}',
                'team' => 'networks/{network_code}/teams/{team}',
            ],
        ],
    ],
];
