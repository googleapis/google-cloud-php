<?php

return [
    'interfaces' => [
        'google.cloud.aiplatform.v1.TensorboardService' => [
            'BatchCreateTensorboardRuns' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*/experiments/*}/runs:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateTensorboardTimeSeries' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*/experiments/*}/runs/*/timeSeries:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchReadTensorboardTimeSeriesData' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{tensorboard=projects/*/locations/*/tensorboards/*}/experiments/*/runs/*/timeSeries:batchRead',
                'placeholders' => [
                    'tensorboard' => [
                        'getters' => [
                            'getTensorboard',
                        ],
                    ],
                ],
            ],
            'CreateTensorboard' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tensorboards',
                'body' => 'tensorboard',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTensorboardExperiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*}/experiments',
                'body' => 'tensorboard_experiment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tensorboard_experiment_id',
                ],
            ],
            'CreateTensorboardRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*/experiments/*}/runs',
                'body' => 'tensorboard_run',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tensorboard_run_id',
                ],
            ],
            'CreateTensorboardTimeSeries' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}/timeSeries',
                'body' => 'tensorboard_time_series',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTensorboard' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTensorboardExperiment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTensorboardRun' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTensorboardTimeSeries' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportTensorboardTimeSeriesData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{tensorboard_time_series=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}:exportTensorboardTimeSeries',
                'body' => '*',
                'placeholders' => [
                    'tensorboard_time_series' => [
                        'getters' => [
                            'getTensorboardTimeSeries',
                        ],
                    ],
                ],
            ],
            'GetTensorboard' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTensorboardExperiment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTensorboardRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTensorboardTimeSeries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTensorboardExperiments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*}/experiments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTensorboardRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*/experiments/*}/runs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTensorboardTimeSeries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}/timeSeries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTensorboards' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tensorboards',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReadTensorboardBlobData' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{time_series=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}:readBlobData',
                'placeholders' => [
                    'time_series' => [
                        'getters' => [
                            'getTimeSeries',
                        ],
                    ],
                ],
            ],
            'ReadTensorboardTimeSeriesData' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{tensorboard_time_series=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}:read',
                'placeholders' => [
                    'tensorboard_time_series' => [
                        'getters' => [
                            'getTensorboardTimeSeries',
                        ],
                    ],
                ],
            ],
            'UpdateTensorboard' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tensorboard.name=projects/*/locations/*/tensorboards/*}',
                'body' => 'tensorboard',
                'placeholders' => [
                    'tensorboard.name' => [
                        'getters' => [
                            'getTensorboard',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTensorboardExperiment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tensorboard_experiment.name=projects/*/locations/*/tensorboards/*/experiments/*}',
                'body' => 'tensorboard_experiment',
                'placeholders' => [
                    'tensorboard_experiment.name' => [
                        'getters' => [
                            'getTensorboardExperiment',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTensorboardRun' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tensorboard_run.name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}',
                'body' => 'tensorboard_run',
                'placeholders' => [
                    'tensorboard_run.name' => [
                        'getters' => [
                            'getTensorboardRun',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTensorboardTimeSeries' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tensorboard_time_series.name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}',
                'body' => 'tensorboard_time_series',
                'placeholders' => [
                    'tensorboard_time_series.name' => [
                        'getters' => [
                            'getTensorboardTimeSeries',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'WriteTensorboardExperimentData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{tensorboard_experiment=projects/*/locations/*/tensorboards/*/experiments/*}:write',
                'body' => '*',
                'placeholders' => [
                    'tensorboard_experiment' => [
                        'getters' => [
                            'getTensorboardExperiment',
                        ],
                    ],
                ],
            ],
            'WriteTensorboardRunData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{tensorboard_run=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}:write',
                'body' => '*',
                'placeholders' => [
                    'tensorboard_run' => [
                        'getters' => [
                            'getTensorboardRun',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/ui/{name=projects/*/locations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}',
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
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/ui/{name=projects/*}/locations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*}/locations',
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
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:getIamPolicy',
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
                'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:setIamPolicy',
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
                'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*}:testIamPermissions',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{resource=projects/*/locations/*/featurestores/*/entityTypes/*}:testIamPermissions',
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
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:cancel',
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
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDeploymentJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/ui/{name=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*}/operations',
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
            'WaitOperation' => [
                'method' => 'post',
                'uriTemplate' => '/ui/{name=projects/*/locations/*/operations/*}:wait',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/edgeDevices/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/endpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/customJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/migratableResources/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/specialistPools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/ui/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/savedQueries/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/annotationSpecs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*/dataItems/*/annotations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/deploymentResourcePools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/endpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/featurestores/*/entityTypes/*/features/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexes/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/migratableResources/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/evaluations/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/studies/*/trials/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/trainingPipelines/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/pipelineJobs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/specialistPools/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/operations/*}:wait',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/tensorboards/*/experiments/*/runs/*/timeSeries/*/operations/*}:wait',
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
        ],
    ],
];
