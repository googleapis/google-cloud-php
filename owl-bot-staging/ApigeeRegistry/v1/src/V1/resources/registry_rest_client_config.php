<?php

return [
    'interfaces' => [
        'google.cloud.apigeeregistry.v1.Registry' => [
            'CreateApi' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apis',
                'body' => 'api',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'api_id',
                ],
            ],
            'CreateApiDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/deployments',
                'body' => 'api_deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'api_deployment_id',
                ],
            ],
            'CreateApiSpec' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/specs',
                'body' => 'api_spec',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'api_spec_id',
                ],
            ],
            'CreateApiVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/versions',
                'body' => 'api_version',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'api_version_id',
                ],
            ],
            'CreateArtifact' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/artifacts',
                'body' => 'artifact',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/artifacts',
                        'body' => 'artifact',
                        'queryParams' => [
                            'artifact_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/artifacts',
                        'body' => 'artifact',
                        'queryParams' => [
                            'artifact_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*/specs/*}/artifacts',
                        'body' => 'artifact',
                        'queryParams' => [
                            'artifact_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/deployments/*}/artifacts',
                        'body' => 'artifact',
                        'queryParams' => [
                            'artifact_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'artifact_id',
                ],
            ],
            'DeleteApi' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApiDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApiDeploymentRevision' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*}:deleteRevision',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApiSpec' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApiSpecRevision' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}:deleteRevision',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApiVersion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteArtifact' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/artifacts/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/artifacts/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/artifacts/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*/artifacts/*}',
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
            'GetApi' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApiDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApiSpec' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApiSpecContents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}:getContents',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApiVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetArtifact' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/artifacts/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/artifacts/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/artifacts/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*/artifacts/*}',
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
            'GetArtifactContents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/artifacts/*}:getContents',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/artifacts/*}:getContents',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/artifacts/*}:getContents',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}:getContents',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*/artifacts/*}:getContents',
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
            'ListApiDeploymentRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*}:listRevisions',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApiDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/deployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApiSpecRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}:listRevisions',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApiSpecs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/specs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApiVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apis',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListArtifacts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/artifacts',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/artifacts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/artifacts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*/specs/*}/artifacts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/deployments/*}/artifacts',
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
            'ReplaceArtifact' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{artifact.name=projects/*/locations/*/artifacts/*}',
                'body' => 'artifact',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{artifact.name=projects/*/locations/*/apis/*/artifacts/*}',
                        'body' => 'artifact',
                    ],
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{artifact.name=projects/*/locations/*/apis/*/versions/*/artifacts/*}',
                        'body' => 'artifact',
                    ],
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{artifact.name=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}',
                        'body' => 'artifact',
                    ],
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{artifact.name=projects/*/locations/*/apis/*/deployments/*/artifacts/*}',
                        'body' => 'artifact',
                    ],
                ],
                'placeholders' => [
                    'artifact.name' => [
                        'getters' => [
                            'getArtifact',
                            'getName',
                        ],
                    ],
                ],
            ],
            'RollbackApiDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RollbackApiSpec' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TagApiDeploymentRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/deployments/*}:tagRevision',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TagApiSpecRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}:tagRevision',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApi' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api.name=projects/*/locations/*/apis/*}',
                'body' => 'api',
                'placeholders' => [
                    'api.name' => [
                        'getters' => [
                            'getApi',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApiDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api_deployment.name=projects/*/locations/*/apis/*/deployments/*}',
                'body' => 'api_deployment',
                'placeholders' => [
                    'api_deployment.name' => [
                        'getters' => [
                            'getApiDeployment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApiSpec' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api_spec.name=projects/*/locations/*/apis/*/versions/*/specs/*}',
                'body' => 'api_spec',
                'placeholders' => [
                    'api_spec.name' => [
                        'getters' => [
                            'getApiSpec',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApiVersion' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api_version.name=projects/*/locations/*/apis/*/versions/*}',
                'body' => 'api_version',
                'placeholders' => [
                    'api_version.name' => [
                        'getters' => [
                            'getApiVersion',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/deployments/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/specs/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/artifacts/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/artifacts/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/artifacts/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/instances/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/runtime}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/deployments/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/specs/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/artifacts/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/artifacts/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/artifacts/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/instances/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/runtime}:setIamPolicy',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/deployments/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/specs/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/artifacts/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/artifacts/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/artifacts/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/apis/*/versions/*/specs/*/artifacts/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/instances/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/runtime}:testIamPermissions',
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
];
