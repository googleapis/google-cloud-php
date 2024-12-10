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
        'google.devtools.artifactregistry.v1.ArtifactRegistry' => [
            'BatchDeleteVersions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/packages/*}/versions:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAttachment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/attachments',
                'body' => 'attachment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'attachment_id',
                ],
            ],
            'CreateRepository' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/repositories',
                'body' => 'repository',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/rules',
                'body' => 'rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTag' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/packages/*}/tags',
                'body' => 'tag',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAttachment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/attachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteFile' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/files/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePackage' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/packages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRepository' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/rules/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/packages/*/tags/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVersion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/packages/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAttachment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/attachments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDockerImage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/dockerImages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/files/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/repositories/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetMavenArtifact' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/mavenArtifacts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNpmPackage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/npmPackages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPackage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/packages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProjectSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/projectSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPythonPackage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pythonPackages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRepository' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/rules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTag' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/packages/*/tags/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVPCSCConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/vpcscConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/packages/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportAptArtifacts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/aptArtifacts:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ImportYumArtifacts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/yumArtifacts:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAttachments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/attachments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDockerImages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/dockerImages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFiles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/files',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMavenArtifacts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/mavenArtifacts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNpmPackages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/npmPackages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPackages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/packages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPythonPackages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/pythonPackages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRepositories' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/repositories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/rules',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/packages/*}/tags',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/packages/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/repositories/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/repositories/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateFile' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{file.name=projects/*/locations/*/repositories/*/files/*}',
                'body' => 'file',
                'placeholders' => [
                    'file.name' => [
                        'getters' => [
                            'getFile',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdatePackage' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{package.name=projects/*/locations/*/repositories/*/packages/*}',
                'body' => 'package',
                'placeholders' => [
                    'package.name' => [
                        'getters' => [
                            'getPackage',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProjectSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{project_settings.name=projects/*/projectSettings}',
                'body' => 'project_settings',
                'placeholders' => [
                    'project_settings.name' => [
                        'getters' => [
                            'getProjectSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRepository' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{repository.name=projects/*/locations/*/repositories/*}',
                'body' => 'repository',
                'placeholders' => [
                    'repository.name' => [
                        'getters' => [
                            'getRepository',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rule.name=projects/*/locations/*/repositories/*/rules/*}',
                'body' => 'rule',
                'placeholders' => [
                    'rule.name' => [
                        'getters' => [
                            'getRule',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTag' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tag.name=projects/*/locations/*/repositories/*/packages/*/tags/*}',
                'body' => 'tag',
                'placeholders' => [
                    'tag.name' => [
                        'getters' => [
                            'getTag',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateVPCSCConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{vpcsc_config.name=projects/*/locations/*/vpcscConfig}',
                'body' => 'vpcsc_config',
                'placeholders' => [
                    'vpcsc_config.name' => [
                        'getters' => [
                            'getVpcscConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateVersion' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{version.name=projects/*/locations/*/repositories/*/packages/*/versions/*}',
                'body' => 'version',
                'placeholders' => [
                    'version.name' => [
                        'getters' => [
                            'getVersion',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
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
        ],
    ],
    'numericEnums' => true,
];
