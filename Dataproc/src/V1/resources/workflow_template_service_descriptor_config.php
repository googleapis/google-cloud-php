<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.WorkflowTemplateService' => [
            'InstantiateInlineWorkflowTemplate' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\WorkflowMetadata',
                    'initialPollDelayMillis' => '1000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '10000',
                    'totalPollTimeoutMillis' => '43200000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'InstantiateWorkflowTemplate' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Dataproc\V1\WorkflowMetadata',
                    'initialPollDelayMillis' => '1000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '10000',
                    'totalPollTimeoutMillis' => '43200000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateWorkflowTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataproc\V1\WorkflowTemplate',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteWorkflowTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkflowTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataproc\V1\WorkflowTemplate',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListWorkflowTemplates' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTemplates',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Dataproc\V1\ListWorkflowTemplatesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateWorkflowTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataproc\V1\WorkflowTemplate',
                'headerParams' => [
                    [
                        'keyName' => 'template.name',
                        'fieldAccessors' => [
                            'getTemplate',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'clusterRegion' => 'projects/{project}/regions/{region}/clusters/{cluster}',
                'location' => 'projects/{project}/locations/{location}',
                'nodeGroup' => 'projects/{project}/regions/{region}/clusters/{cluster}/nodeGroups/{node_group}',
                'projectLocationWorkflowTemplate' => 'projects/{project}/locations/{location}/workflowTemplates/{workflow_template}',
                'projectRegionWorkflowTemplate' => 'projects/{project}/regions/{region}/workflowTemplates/{workflow_template}',
                'region' => 'projects/{project}/regions/{region}',
                'service' => 'projects/{project}/locations/{location}/services/{service}',
                'workflowTemplate' => 'projects/{project}/regions/{region}/workflowTemplates/{workflow_template}',
            ],
        ],
    ],
];
