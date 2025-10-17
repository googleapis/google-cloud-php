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

// [START routeoptimization_v1_generated_RouteOptimization_OptimizeToursLongRunning_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Maps\RouteOptimization\V1\Client\RouteOptimizationClient;
use Google\Maps\RouteOptimization\V1\OptimizeToursRequest;
use Google\Maps\RouteOptimization\V1\OptimizeToursResponse;
use Google\Rpc\Status;

/**
 * This is a variant of the
 * [OptimizeTours][google.maps.routeoptimization.v1.RouteOptimization.OptimizeTours]
 * method designed for
 * optimizations with large timeout values. It should be preferred over the
 * `OptimizeTours` method for optimizations that take longer than
 * a few minutes.
 *
 * The returned [long-running operation][google.longrunning.Operation] (LRO)
 * will have a name of the format
 * `<parent>/operations/<operation_id>` and can be used to track
 * progress of the computation. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [OptimizeToursLongRunningMetadata][google.maps.routeoptimization.v1.OptimizeToursLongRunningMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [OptimizeToursResponse][google.maps.routeoptimization.v1.OptimizeToursResponse],
 * if successful.
 *
 * Experimental: See
 * https://developers.google.com/maps/tt/route-optimization/experimental/otlr/make-request
 * for more details.
 *
 *
 * @param string $parent Target project or location to make a call.
 *
 *                       Format:
 *                       * `projects/{project-id}`
 *                       * `projects/{project-id}/locations/{location-id}`
 *
 *                       If no location is specified, a region will be chosen automatically.
 */
function optimize_tours_long_running_sample(string $parent): void
{
    // Create a client.
    $routeOptimizationClient = new RouteOptimizationClient();

    // Prepare the request message.
    $request = (new OptimizeToursRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $routeOptimizationClient->optimizeToursLongRunning($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var OptimizeToursResponse $result */
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

    optimize_tours_long_running_sample($parent);
}
// [END routeoptimization_v1_generated_RouteOptimization_OptimizeToursLongRunning_sync]
