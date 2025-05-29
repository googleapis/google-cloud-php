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
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\BacktestResult',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '600000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '7200000',
                    'totalPollTimeoutMillis' => '172800000',
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
            'CreateDataset' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\Dataset',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
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
            'CreateEngineConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\EngineConfig',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '600000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '7200000',
                    'totalPollTimeoutMillis' => '259200000',
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
            'CreateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
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
            'CreateModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\Model',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '600000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '7200000',
                    'totalPollTimeoutMillis' => '259200000',
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
            'CreatePredictionResult' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\PredictionResult',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '600000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '7200000',
                    'totalPollTimeoutMillis' => '172800000',
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
            'DeleteBacktestResult' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
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
            'DeleteDataset' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '300000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '1800000',
                    'totalPollTimeoutMillis' => '86400000',
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
            'DeleteEngineConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
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
            'DeleteInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '600000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '7200000',
                    'totalPollTimeoutMillis' => '259200000',
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
            'DeleteModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
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
            'DeletePredictionResult' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
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
            'ExportBacktestResultMetadata' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\ExportBacktestResultMetadataResponse',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '300000',
                    'totalPollTimeoutMillis' => '7200000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'backtest_result',
                        'fieldAccessors' => [
                            'getBacktestResult',
                        ],
                    ],
                ],
            ],
            'ExportEngineConfigMetadata' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\ExportEngineConfigMetadataResponse',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'engine_config',
                        'fieldAccessors' => [
                            'getEngineConfig',
                        ],
                    ],
                ],
            ],
            'ExportModelMetadata' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\ExportModelMetadataResponse',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'model',
                        'fieldAccessors' => [
                            'getModel',
                        ],
                    ],
                ],
            ],
            'ExportPredictionResultMetadata' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\ExportPredictionResultMetadataResponse',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '300000',
                    'totalPollTimeoutMillis' => '7200000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'prediction_result',
                        'fieldAccessors' => [
                            'getPredictionResult',
                        ],
                    ],
                ],
            ],
            'ExportRegisteredParties' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\ExportRegisteredPartiesResponse',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
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
            'ImportRegisteredParties' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\ImportRegisteredPartiesResponse',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '30000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '180000',
                    'totalPollTimeoutMillis' => '1200000',
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
            'UpdateBacktestResult' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\BacktestResult',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'backtest_result.name',
                        'fieldAccessors' => [
                            'getBacktestResult',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDataset' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\Dataset',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '300000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '1800000',
                    'totalPollTimeoutMillis' => '86400000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'dataset.name',
                        'fieldAccessors' => [
                            'getDataset',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEngineConfig' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\EngineConfig',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'engine_config.name',
                        'fieldAccessors' => [
                            'getEngineConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\Instance',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'instance.name',
                        'fieldAccessors' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\Model',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'model.name',
                        'fieldAccessors' => [
                            'getModel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePredictionResult' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\FinancialServices\V1\PredictionResult',
                    'metadataReturnType' => '\Google\Cloud\FinancialServices\V1\OperationMetadata',
                    'initialPollDelayMillis' => '5000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'prediction_result.name',
                        'fieldAccessors' => [
                            'getPredictionResult',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBacktestResult' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\BacktestResult',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataset' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\Dataset',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEngineConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\EngineConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEngineVersion' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\EngineVersion',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\Instance',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetModel' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\Model',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPredictionResult' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\PredictionResult',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBacktestResults' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBacktestResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListBacktestResultsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatasets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDatasets',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListDatasetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEngineConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEngineConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListEngineConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEngineVersions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEngineVersions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListEngineVersionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstances',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListInstancesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListModels' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getModels',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListModelsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPredictionResults' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getPredictionResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\FinancialServices\V1\ListPredictionResultsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLocation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Location\Location',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Location\ListLocationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
                'interfaceOverride' => 'google.cloud.location.Locations',
            ],
            'templateMap' => [
                'backtestResult' => 'projects/{project_num}/locations/{location}/instances/{instance}/backtestResults/{backtest_result}',
                'dataset' => 'projects/{project_num}/locations/{location}/instances/{instance}/datasets/{dataset}',
                'engineConfig' => 'projects/{project_num}/locations/{location}/instances/{instance}/engineConfigs/{engine_config}',
                'engineVersion' => 'projects/{project_num}/locations/{location}/instances/{instance}/engineVersions/{engine_version}',
                'instance' => 'projects/{project}/locations/{location}/instances/{instance}',
                'location' => 'projects/{project}/locations/{location}',
                'model' => 'projects/{project_num}/locations/{location}/instances/{instance}/models/{model}',
                'predictionResult' => 'projects/{project_num}/locations/{location}/instances/{instance}/predictionResults/{prediction_result}',
            ],
        ],
    ],
];
