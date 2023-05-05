<?php
/*
 * Copyright 2022 Google LLC
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

// [START cloudoptimization_v1_generated_FleetRouting_BatchOptimizeTours_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Optimization\V1\BatchOptimizeToursRequest\AsyncModelConfig;
use Google\Cloud\Optimization\V1\BatchOptimizeToursResponse;
use Google\Cloud\Optimization\V1\FleetRoutingClient;
use Google\Cloud\Optimization\V1\InputConfig;
use Google\Cloud\Optimization\V1\OutputConfig;
use Google\Rpc\Status;

/**
 * Optimizes vehicle tours for one or more `OptimizeToursRequest`
 * messages as a batch.
 *
 * This method is a Long Running Operation (LRO). The inputs for optimization
 * (`OptimizeToursRequest` messages) and outputs (`OptimizeToursResponse`
 * messages) are read/written from/to Cloud Storage in user-specified
 * format. Like the `OptimizeTours` method, each `OptimizeToursRequest`
 * contains a `ShipmentModel` and returns an `OptimizeToursResponse`
 * containing `ShipmentRoute`s, which are a set of routes to be performed by
 * vehicles minimizing the overall cost.
 *
 * @param string $parent Target project and location to make a call.
 *
 *                       Format: `projects/{project-id}/locations/{location-id}`.
 *
 *                       If no location is specified, a region will be chosen automatically.
 */
function batch_optimize_tours_sample(string $parent): void
{
    // Create a client.
    $fleetRoutingClient = new FleetRoutingClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $modelConfigsInputConfig = new InputConfig();
    $modelConfigsOutputConfig = new OutputConfig();
    $asyncModelConfig = (new AsyncModelConfig())
        ->setInputConfig($modelConfigsInputConfig)
        ->setOutputConfig($modelConfigsOutputConfig);
    $modelConfigs = [$asyncModelConfig,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $fleetRoutingClient->batchOptimizeTours($parent, $modelConfigs);
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

    batch_optimize_tours_sample($parent);
}
// [END cloudoptimization_v1_generated_FleetRouting_BatchOptimizeTours_sync]
