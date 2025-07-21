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

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START financialservices_v1_generated_AML_UpdateBacktestResult_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\FinancialServices\V1\BacktestResult;
use Google\Cloud\FinancialServices\V1\BacktestResult\PerformanceTarget;
use Google\Cloud\FinancialServices\V1\Client\AMLClient;
use Google\Cloud\FinancialServices\V1\UpdateBacktestResultRequest;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single BacktestResult.
 *
 * @param string $formattedBacktestResultDataset                                  The resource name of the Dataset to backtest on
 *                                                                                Format:
 *                                                                                `/projects/{project_num}/locations/{location}/instances/{instance}/datasets/{dataset}`
 *                                                                                Please see {@see AMLClient::datasetName()} for help formatting this field.
 * @param string $formattedBacktestResultModel                                    The resource name of the Model to use or to backtest.
 *                                                                                Format:
 *                                                                                `/projects/{project_num}/locations/{location}/instances/{instance}/models/{model}`
 *                                                                                Please see {@see AMLClient::modelName()} for help formatting this field.
 * @param int    $backtestResultPerformanceTargetPartyInvestigationsPerPeriodHint A number that gives the tuner a hint on the number of parties
 *                                                                                from this data that will be investigated per period (monthly). This is
 *                                                                                used to control how the model is evaluated. For example, when trying AML
 *                                                                                AI for the first time, we recommend setting this to the number of parties
 *                                                                                investigated in an average month, based on alerts from your existing
 *                                                                                automated alerting system.
 */
function update_backtest_result_sample(
    string $formattedBacktestResultDataset,
    string $formattedBacktestResultModel,
    int $backtestResultPerformanceTargetPartyInvestigationsPerPeriodHint
): void {
    // Create a client.
    $aMLClient = new AMLClient();

    // Prepare the request message.
    $backtestResultEndTime = new Timestamp();
    $backtestResultPerformanceTarget = (new PerformanceTarget())
        ->setPartyInvestigationsPerPeriodHint(
            $backtestResultPerformanceTargetPartyInvestigationsPerPeriodHint
        );
    $backtestResult = (new BacktestResult())
        ->setDataset($formattedBacktestResultDataset)
        ->setModel($formattedBacktestResultModel)
        ->setEndTime($backtestResultEndTime)
        ->setPerformanceTarget($backtestResultPerformanceTarget);
    $request = (new UpdateBacktestResultRequest())
        ->setBacktestResult($backtestResult);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $aMLClient->updateBacktestResult($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BacktestResult $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedBacktestResultDataset = AMLClient::datasetName(
        '[PROJECT_NUM]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DATASET]'
    );
    $formattedBacktestResultModel = AMLClient::modelName(
        '[PROJECT_NUM]',
        '[LOCATION]',
        '[INSTANCE]',
        '[MODEL]'
    );
    $backtestResultPerformanceTargetPartyInvestigationsPerPeriodHint = 0;

    update_backtest_result_sample(
        $formattedBacktestResultDataset,
        $formattedBacktestResultModel,
        $backtestResultPerformanceTargetPartyInvestigationsPerPeriodHint
    );
}
// [END financialservices_v1_generated_AML_UpdateBacktestResult_sync]
