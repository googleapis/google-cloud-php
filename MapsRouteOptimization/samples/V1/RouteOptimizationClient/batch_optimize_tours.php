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

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START routeoptimization_v1_generated_RouteOptimization_BatchOptimizeTours_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Maps\RouteOptimization\V1\BatchOptimizeToursRequest;
use Google\Maps\RouteOptimization\V1\BatchOptimizeToursRequest\AsyncModelConfig;
use Google\Maps\RouteOptimization\V1\BatchOptimizeToursResponse;
use Google\Maps\RouteOptimization\V1\Client\RouteOptimizationClient;
use Google\Maps\RouteOptimization\V1\DataFormat;
use Google\Maps\RouteOptimization\V1\InputConfig;
use Google\Maps\RouteOptimization\V1\OutputConfig;
use Google\Rpc\Status;

/**
 * Optimizes vehicle tours for one or more `OptimizeToursRequest`
 * messages as a batch.
 *
 * This method is a Long Running Operation (LRO). The inputs for optimization
 * (`OptimizeToursRequest` messages) and outputs (`OptimizeToursResponse`
 * messages) are read from and written to Cloud Storage in user-specified
 * format. Like the `OptimizeTours` method, each `OptimizeToursRequest`
 * contains a `ShipmentModel` and returns an `OptimizeToursResponse`
 * containing `ShipmentRoute` fields, which are a set of routes to be
 * performed by vehicles minimizing the overall cost.
 *
 * The user can poll `operations.get` to check the status of the LRO:
 *
 * If the LRO `done` field is false, then at least one request is still
 * being processed. Other requests may have completed successfully and their
 * results are available in Cloud Storage.
 *
 * If the LRO's `done` field is true, then all requests have been processed.
 * Any successfully processed requests will have their results available in
 * Cloud Storage. Any requests that failed will not have their results
 * available in Cloud Storage. If the LRO's `error` field is set, then it
 * contains the error from one of the failed requests.
 *
 * @param string $parent                             Target project and location to make a call.
 *
 *                                                   Format:
 *                                                   * `projects/{project-id}`
 *                                                   * `projects/{project-id}/locations/{location-id}`
 *
 *                                                   If no location is specified, a region will be chosen automatically.
 * @param int    $modelConfigsInputConfigDataFormat  The input data format.
 * @param int    $modelConfigsOutputConfigDataFormat The output data format.
 */
function batch_optimize_tours_sample(
    string $parent,
    int $modelConfigsInputConfigDataFormat,
    int $modelConfigsOutputConfigDataFormat
): void {
    // Create a client.
    $routeOptimizationClient = new RouteOptimizationClient();

    // Prepare the request message.
    $modelConfigsInputConfig = (new InputConfig())
        ->setDataFormat($modelConfigsInputConfigDataFormat);
    $modelConfigsOutputConfig = (new OutputConfig())
        ->setDataFormat($modelConfigsOutputConfigDataFormat);
    $asyncModelConfig = (new AsyncModelConfig())
        ->setInputConfig($modelConfigsInputConfig)
        ->setOutputConfig($modelConfigsOutputConfig);
    $modelConfigs = [$asyncModelConfig,];
    $request = (new BatchOptimizeToursRequest())
        ->setParent($parent)
        ->setModelConfigs($modelConfigs);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $routeOptimizationClient->batchOptimizeTours($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchOptimizeToursResponse $result */
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
    $parent = '[PARENT]';
    $modelConfigsInputConfigDataFormat = DataFormat::DATA_FORMAT_UNSPECIFIED;
    $modelConfigsOutputConfigDataFormat = DataFormat::DATA_FORMAT_UNSPECIFIED;

    batch_optimize_tours_sample(
        $parent,
        $modelConfigsInputConfigDataFormat,
        $modelConfigsOutputConfigDataFormat
    );
}
// [END routeoptimization_v1_generated_RouteOptimization_BatchOptimizeTours_sync]
