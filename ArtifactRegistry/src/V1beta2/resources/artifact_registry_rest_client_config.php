<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.devtools.artifactregistry.v1beta2.ArtifactRegistry' => [
            'CreateRepository' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/repositories',
                'body' => 'repository',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*/packages/*}/tags',
                'body' => 'tag',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeletePackage' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/packages/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/packages/*/tags/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/packages/*/versions/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/files/**}',
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
                'uriTemplate' => '/v1beta2/{resource=projects/*/locations/*/repositories/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetPackage' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/packages/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/projectSettings}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/packages/*/tags/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/repositories/*/packages/*/versions/*}',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*}/aptArtifacts:import',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*}/yumArtifacts:import',
                'body' => '*',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*}/files',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*}/packages',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/repositories',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*/packages/*}/tags',
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
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*/repositories/*/packages/*}/versions',
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
                'uriTemplate' => '/v1beta2/{resource=projects/*/locations/*/repositories/*}:setIamPolicy',
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
                'uriTemplate' => '/v1beta2/{resource=projects/*/locations/*/repositories/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateProjectSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta2/{project_settings.name=projects/*/projectSettings}',
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
                'uriTemplate' => '/v1beta2/{repository.name=projects/*/locations/*/repositories/*}',
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
            'UpdateTag' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta2/{tag.name=projects/*/locations/*/repositories/*/packages/*/tags/*}',
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
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/operations/*}',
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
