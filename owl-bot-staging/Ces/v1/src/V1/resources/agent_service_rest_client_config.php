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
        'google.cloud.ces.v1.AgentService' => [
            'BatchDeleteConversations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/conversations:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAgent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/agents',
                'body' => 'agent',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateApp' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apps',
                'body' => 'app',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAppVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/versions',
                'body' => 'app_version',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/deployments',
                'body' => 'deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateExample' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/examples',
                'body' => 'example',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateGuardrail' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/guardrails',
                'body' => 'guardrail',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/tools',
                'body' => 'tool',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateToolset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/toolsets',
                'body' => 'toolset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAgent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/agents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApp' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAppVersion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConversation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/conversations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExample' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/examples/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGuardrail' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/guardrails/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/tools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteToolset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/toolsets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportApp' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*}:exportApp',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAgent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/agents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApp' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAppVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChangelog' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/changelogs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConversation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/conversations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExample' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/examples/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGuardrail' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/guardrails/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/tools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetToolset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/toolsets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportApp' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apps:importApp',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAgents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/agents',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAppVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apps',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListChangelogs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/changelogs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListConversations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/conversations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/deployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExamples' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/examples',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGuardrails' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/guardrails',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/tools',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListToolsets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apps/*}/toolsets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RestoreAppVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apps/*/versions/*}:restore',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAgent' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{agent.name=projects/*/locations/*/apps/*/agents/*}',
                'body' => 'agent',
                'placeholders' => [
                    'agent.name' => [
                        'getters' => [
                            'getAgent',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApp' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{app.name=projects/*/locations/*/apps/*}',
                'body' => 'app',
                'placeholders' => [
                    'app.name' => [
                        'getters' => [
                            'getApp',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{deployment.name=projects/*/locations/*/apps/*/deployments/*}',
                'body' => 'deployment',
                'placeholders' => [
                    'deployment.name' => [
                        'getters' => [
                            'getDeployment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExample' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{example.name=projects/*/locations/*/apps/*/examples/*}',
                'body' => 'example',
                'placeholders' => [
                    'example.name' => [
                        'getters' => [
                            'getExample',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGuardrail' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{guardrail.name=projects/*/locations/*/apps/*/guardrails/*}',
                'body' => 'guardrail',
                'placeholders' => [
                    'guardrail.name' => [
                        'getters' => [
                            'getGuardrail',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tool.name=projects/*/locations/*/apps/*/tools/*}',
                'body' => 'tool',
                'placeholders' => [
                    'tool.name' => [
                        'getters' => [
                            'getTool',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateToolset' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{toolset.name=projects/*/locations/*/apps/*/toolsets/*}',
                'body' => 'toolset',
                'placeholders' => [
                    'toolset.name' => [
                        'getters' => [
                            'getToolset',
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
