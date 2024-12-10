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
        'google.cloud.datacatalog.v1.DataCatalog' => [
            'CreateEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*}/entries',
                'body' => 'entry',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'entry_id',
                ],
            ],
            'CreateEntryGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/entryGroups',
                'body' => 'entry_group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'entry_group_id',
                ],
            ],
            'CreateTag' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*/entries/*}/tags',
                'body' => 'tag',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*}/tags',
                        'body' => 'tag',
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
            'CreateTagTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tagTemplates',
                'body' => 'tag_template',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tag_template_id',
                ],
            ],
            'CreateTagTemplateField' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tagTemplates/*}/fields',
                'body' => 'tag_template_field',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tag_template_field_id',
                ],
            ],
            'DeleteEntry' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEntryGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTag' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*/tags/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/tags/*}',
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
            'DeleteTagTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tagTemplates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'force',
                ],
            ],
            'DeleteTagTemplateField' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tagTemplates/*/fields/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'force',
                ],
            ],
            'GetEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEntryGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/tagTemplates/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*}:getIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*/entries/*}:getIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetTagTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tagTemplates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportEntries' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*}/entries:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEntries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*}/entries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEntryGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/entryGroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTags' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*/entries/*}/tags',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*}/tags',
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
            'LookupEntry' => [
                'method' => 'get',
                'uriTemplate' => '/v1/entries:lookup',
            ],
            'ModifyEntryContacts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*}:modifyEntryContacts',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ModifyEntryOverview' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*}:modifyEntryOverview',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReconcileTags' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/entryGroups/*/entries/*}/tags:reconcile',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RenameTagTemplateField' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tagTemplates/*/fields/*}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RenameTagTemplateFieldEnumValue' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tagTemplates/*/fields/*/enumValues/*}:rename',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RetrieveConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*}:retrieveConfig',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RetrieveEffectiveConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*}:retrieveEffectiveConfig',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}:retrieveEffectiveConfig',
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
            'SearchCatalog' => [
                'method' => 'post',
                'uriTemplate' => '/v1/catalog:search',
                'body' => '*',
            ],
            'SetConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*}:setConfig',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}:setConfig',
                        'body' => '*',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/tagTemplates/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'StarEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*}:star',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/tagTemplates/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/entryGroups/*/entries/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UnstarEntry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/entryGroups/*/entries/*}:unstar',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEntry' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{entry.name=projects/*/locations/*/entryGroups/*/entries/*}',
                'body' => 'entry',
                'placeholders' => [
                    'entry.name' => [
                        'getters' => [
                            'getEntry',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEntryGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{entry_group.name=projects/*/locations/*/entryGroups/*}',
                'body' => 'entry_group',
                'placeholders' => [
                    'entry_group.name' => [
                        'getters' => [
                            'getEntryGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTag' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tag.name=projects/*/locations/*/entryGroups/*/entries/*/tags/*}',
                'body' => 'tag',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{tag.name=projects/*/locations/*/entryGroups/*/tags/*}',
                        'body' => 'tag',
                    ],
                ],
                'placeholders' => [
                    'tag.name' => [
                        'getters' => [
                            'getTag',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTagTemplate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tag_template.name=projects/*/locations/*/tagTemplates/*}',
                'body' => 'tag_template',
                'placeholders' => [
                    'tag_template.name' => [
                        'getters' => [
                            'getTagTemplate',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTagTemplateField' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tagTemplates/*/fields/*}',
                'body' => 'tag_template_field',
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
];
