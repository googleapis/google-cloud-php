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
        'google.cloud.designcenter.v1.DesignCenter' => [
            'CommitApplicationTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:commit',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/applications',
                'body' => 'application',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'application_id',
                ],
            ],
            'CreateApplicationTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/applicationTemplates',
                'body' => 'application_template',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'application_template_id',
                ],
            ],
            'CreateCatalog' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/catalogs',
                'body' => 'catalog',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'catalog_id',
                ],
            ],
            'CreateCatalogTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/catalogs/*}/templates',
                'body' => 'catalog_template',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'catalog_template_id',
                ],
            ],
            'CreateCatalogTemplateRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/catalogs/*/templates/*}/revisions',
                'body' => 'catalog_template_revision',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'catalog_template_revision_id',
                ],
            ],
            'CreateComponent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*}/components',
                'body' => 'component',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'component_id',
                ],
            ],
            'CreateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*}/connections',
                'body' => 'connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'connection_id',
                ],
            ],
            'CreatePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*}/policies',
                'body' => 'policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'policy_id',
                ],
            ],
            'CreateShare' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/catalogs/*}/shares',
                'body' => 'share',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'share_id',
                ],
            ],
            'CreateSpace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/spaces',
                'body' => 'space',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'space_id',
                ],
            ],
            'DeleteApplication' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApplicationTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApplicationTemplateRevision' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCatalog' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCatalogTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/templates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCatalogTemplateRevision' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/templates/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteComponent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/policies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteShare' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/shares/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSpace' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeployApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:deploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportApplicationIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportApplicationTemplateIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportApplicationTemplateRevisionIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/revisions/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchApplicationAssessmentReport' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:fetchAssessmentReport',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchFrameworks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:fetchFrameworks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GenerateApplicationAssessmentReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:generateAssessmentReport',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateApplicationIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:generate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateApplicationTemplateAssessmentReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:generateAssessmentReport',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateApplicationTemplateIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:generate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateApplicationTemplateRevisionIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/revisions/*}:generate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAssessmentReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{space_name=projects/*/locations/*/spaces/*}:generateAssessmentReport',
                'body' => '*',
                'placeholders' => [
                    'space_name' => [
                        'getters' => [
                            'getSpaceName',
                        ],
                    ],
                ],
            ],
            'GenerateTerraformPlanAssessmentReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*}:generateTerraformPlanAssessmentReport',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApplication' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApplicationTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApplicationTemplateRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApplicationTemplateSystemRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/systemRevisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCatalog' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCatalogTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/templates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCatalogTemplateRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/templates/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetComponent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*/policies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetShare' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/shares/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSharedTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/sharedTemplates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSharedTemplateRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/sharedTemplates/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpace' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportApplicationIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:importIaC',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportApplicationTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:import',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportApplicationTemplateIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:importIaC',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'IngestApplicationTemplateIaC' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:ingestIaC',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApplicationTemplateRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*}/revisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApplicationTemplateSystemRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*}/systemRevisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApplicationTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/applicationTemplates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApplications' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/applications',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCatalogTemplateRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/catalogs/*/templates/*}/revisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCatalogTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/catalogs/*}/templates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCatalogs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/catalogs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListComponents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*}/components',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*}/connections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/applicationTemplates/*}/policies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSharedTemplateRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/sharedTemplates/*}/revisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSharedTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*}/sharedTemplates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListShares' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/spaces/*/catalogs/*}/shares',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSpaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/spaces',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:preview',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RecommendIAMRoles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applications/*}:recommendIAMRoles',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RegisterAppHubApplicationResources' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/spaces:registerAppHubApplicationResources',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SnapshotApplicationTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/applicationTemplates/*}:snapshot',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SyncShare' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/spaces/*/catalogs/*/shares/*}:sync',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplication' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{application.name=projects/*/locations/*/spaces/*/applications/*}',
                'body' => 'application',
                'placeholders' => [
                    'application.name' => [
                        'getters' => [
                            'getApplication',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplicationTemplate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{application_template.name=projects/*/locations/*/spaces/*/applicationTemplates/*}',
                'body' => 'application_template',
                'placeholders' => [
                    'application_template.name' => [
                        'getters' => [
                            'getApplicationTemplate',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCatalog' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{catalog.name=projects/*/locations/*/spaces/*/catalogs/*}',
                'body' => 'catalog',
                'placeholders' => [
                    'catalog.name' => [
                        'getters' => [
                            'getCatalog',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCatalogTemplate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{catalog_template.name=projects/*/locations/*/spaces/*/catalogs/*/templates/*}',
                'body' => 'catalog_template',
                'placeholders' => [
                    'catalog_template.name' => [
                        'getters' => [
                            'getCatalogTemplate',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateComponent' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{component.name=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*}',
                'body' => 'component',
                'placeholders' => [
                    'component.name' => [
                        'getters' => [
                            'getComponent',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateConnection' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{connection.name=projects/*/locations/*/spaces/*/applicationTemplates/*/components/*/connections/*}',
                'body' => 'connection',
                'placeholders' => [
                    'connection.name' => [
                        'getters' => [
                            'getConnection',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{policy.name=projects/*/locations/*/spaces/*/applicationTemplates/*/policies/*}',
                'body' => 'policy',
                'placeholders' => [
                    'policy.name' => [
                        'getters' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSpace' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{space.name=projects/*/locations/*/spaces/*}',
                'body' => 'space',
                'placeholders' => [
                    'space.name' => [
                        'getters' => [
                            'getSpace',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/spaces/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/spaces/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/spaces/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
