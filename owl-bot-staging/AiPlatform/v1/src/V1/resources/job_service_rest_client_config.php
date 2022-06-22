<?php

return [
    'interfaces' => [
        'google.cloud.aiplatform.v1.JobService' => [
            'CancelBatchPredictionJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/batchPredictionJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelCustomJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelDataLabelingJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelHyperparameterTuningJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateBatchPredictionJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/batchPredictionJobs',
                'body' => 'batch_prediction_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/customJobs',
                'body' => 'custom_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDataLabelingJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataLabelingJobs',
                'body' => 'data_labeling_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateHyperparameterTuningJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/hyperparameterTuningJobs',
                'body' => 'hyperparameter_tuning_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateModelDeploymentMonitoringJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/modelDeploymentMonitoringJobs',
                'body' => 'model_deployment_monitoring_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteBatchPredictionJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/batchPredictionJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCustomJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataLabelingJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteHyperparameterTuningJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteModelDeploymentMonitoringJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBatchPredictionJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/batchPredictionJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/customJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataLabelingJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataLabelingJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHyperparameterTuningJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/hyperparameterTuningJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetModelDeploymentMonitoringJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBatchPredictionJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/batchPredictionJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/customJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataLabelingJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataLabelingJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHyperparameterTuningJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/hyperparameterTuningJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListModelDeploymentMonitoringJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/modelDeploymentMonitoringJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PauseModelDeploymentMonitoringJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}:pause',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeModelDeploymentMonitoringJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchModelDeploymentMonitoringStatsAnomalies' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{model_deployment_monitoring_job=projects/*/locations/*/modelDeploymentMonitoringJobs/*}:searchModelDeploymentMonitoringStatsAnomalies',
                'body' => '*',
                'placeholders' => [
                    'model_deployment_monitoring_job' => [
                        'getters' => [
                            'getModelDeploymentMonitoringJob',
                        ],
                    ],
                ],
            ],
            'UpdateModelDeploymentMonitoringJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{model_deployment_monitoring_job.name=projects/*/locations/*/modelDeploymentMonitoringJobs/*}',
                'body' => 'model_deployment_monitoring_job',
                'placeholders' => [
                    'model_deployment_monitoring_job.name' => [
                        'getters' => [
                            'getModelDeploymentMonitoringJob',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
