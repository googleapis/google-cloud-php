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
        'google.storage.control.v2.StorageControl' => [
            'CreateFolder' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/buckets/*}/folders',
                'body' => 'folder',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'folder_id',
                ],
            ],
            'DeleteFolder' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/buckets/*/folders/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteFolderRecursive' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/buckets/*/folders/**}:deleteRecursive',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFolder' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/buckets/*/folders/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFolderIntelligenceConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=folders/*/locations/*/intelligenceConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIntelligenceFinding' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/intelligenceFindings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIntelligenceFindingRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/intelligenceFindings/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOrganizationIntelligenceConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/locations/*/intelligenceConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProjectIntelligenceConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/intelligenceConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetStorageLayout' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/buckets/*/storageLayout}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListFolders' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/buckets/*}/folders',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIntelligenceFindingRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/intelligenceFindings/*}/revisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIntelligenceFindings' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/intelligenceFindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RenameFolder' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/buckets/*/folders/**}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SummarizeIntelligenceFindings' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/intelligenceFindings:summarize',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/intelligenceFindings:summarize',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/intelligenceFindings:summarize',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateFolderIntelligenceConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{intelligence_config.name=folders/*/locations/*/intelligenceConfig}',
                'body' => 'intelligence_config',
                'placeholders' => [
                    'intelligence_config.name' => [
                        'getters' => [
                            'getIntelligenceConfig',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateOrganizationIntelligenceConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{intelligence_config.name=organizations/*/locations/*/intelligenceConfig}',
                'body' => 'intelligence_config',
                'placeholders' => [
                    'intelligence_config.name' => [
                        'getters' => [
                            'getIntelligenceConfig',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateProjectIntelligenceConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{intelligence_config.name=projects/*/locations/*/intelligenceConfig}',
                'body' => 'intelligence_config',
                'placeholders' => [
                    'intelligence_config.name' => [
                        'getters' => [
                            'getIntelligenceConfig',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
];
