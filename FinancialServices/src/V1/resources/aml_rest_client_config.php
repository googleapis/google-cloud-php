<?php
/*
 * Copyright 2025 Google LLC
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
        'google.cloud.financialservices.v1.AML' => [
            'CreateBacktestResult' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/backtestResults',
                'body' => 'backtest_result',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'backtest_result_id',
                ],
            ],
            'CreateDataset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/datasets',
                'body' => 'dataset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'dataset_id',
                ],
            ],
            'CreateEngineConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/engineConfigs',
                'body' => 'engine_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'engine_config_id',
                ],
            ],
            'CreateInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/instances',
                'body' => 'instance',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'instance_id',
                ],
            ],
            'CreateModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/models',
                'body' => 'model',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'model_id',
                ],
            ],
            'CreatePredictionResult' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/predictionResults',
                'body' => 'prediction_result',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'prediction_result_id',
                ],
            ],
            'DeleteBacktestResult' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/backtestResults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEngineConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/engineConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteModel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/models/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePredictionResult' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/predictionResults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportBacktestResultMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{backtest_result=projects/*/locations/*/instances/*/backtestResults/*}:exportMetadata',
                'body' => '*',
                'placeholders' => [
                    'backtest_result' => [
                        'getters' => [
                            'getBacktestResult',
                        ],
                    ],
                ],
            ],
            'ExportEngineConfigMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{engine_config=projects/*/locations/*/instances/*/engineConfigs/*}:exportMetadata',
                'body' => '*',
                'placeholders' => [
                    'engine_config' => [
                        'getters' => [
                            'getEngineConfig',
                        ],
                    ],
                ],
            ],
            'ExportModelMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{model=projects/*/locations/*/instances/*/models/*}:exportMetadata',
                'body' => '*',
                'placeholders' => [
                    'model' => [
                        'getters' => [
                            'getModel',
                        ],
                    ],
                ],
            ],
            'ExportPredictionResultMetadata' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{prediction_result=projects/*/locations/*/instances/*/predictionResults/*}:exportMetadata',
                'body' => '*',
                'placeholders' => [
                    'prediction_result' => [
                        'getters' => [
                            'getPredictionResult',
                        ],
                    ],
                ],
            ],
            'ExportRegisteredParties' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}:exportRegisteredParties',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBacktestResult' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/backtestResults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEngineConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/engineConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEngineVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/engineVersions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetModel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/models/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPredictionResult' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/predictionResults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportRegisteredParties' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}:importRegisteredParties',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBacktestResults' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/backtestResults',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/datasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEngineConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/engineConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEngineVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/engineVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListModels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/models',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPredictionResults' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/predictionResults',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateBacktestResult' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backtest_result.name=projects/*/locations/*/instances/*/backtestResults/*}',
                'body' => 'backtest_result',
                'placeholders' => [
                    'backtest_result.name' => [
                        'getters' => [
                            'getBacktestResult',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDataset' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dataset.name=projects/*/locations/*/instances/*/datasets/*}',
                'body' => 'dataset',
                'placeholders' => [
                    'dataset.name' => [
                        'getters' => [
                            'getDataset',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEngineConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{engine_config.name=projects/*/locations/*/instances/*/engineConfigs/*}',
                'body' => 'engine_config',
                'placeholders' => [
                    'engine_config.name' => [
                        'getters' => [
                            'getEngineConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{instance.name=projects/*/locations/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getters' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateModel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{model.name=projects/*/locations/*/instances/*/models/*}',
                'body' => 'model',
                'placeholders' => [
                    'model.name' => [
                        'getters' => [
                            'getModel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePredictionResult' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{prediction_result.name=projects/*/locations/*/instances/*/predictionResults/*}',
                'body' => 'prediction_result',
                'placeholders' => [
                    'prediction_result.name' => [
                        'getters' => [
                            'getPredictionResult',
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
