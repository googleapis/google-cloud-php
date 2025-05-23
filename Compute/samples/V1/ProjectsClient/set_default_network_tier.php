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

// [START compute_v1_generated_Projects_SetDefaultNetworkTier_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\ProjectsClient;
use Google\Cloud\Compute\V1\ProjectsSetDefaultNetworkTierRequest;
use Google\Cloud\Compute\V1\SetDefaultNetworkTierProjectRequest;
use Google\Rpc\Status;

/**
 * Sets the default network tier of the project. The default network tier is used when an address/forwardingRule/instance is created without specifying the network tier field.
 *
 * @param string $project Project ID for this request.
 */
function set_default_network_tier_sample(string $project): void
{
    // Create a client.
    $projectsClient = new ProjectsClient();

    // Prepare the request message.
    $projectsSetDefaultNetworkTierRequestResource = new ProjectsSetDefaultNetworkTierRequest();
    $request = (new SetDefaultNetworkTierProjectRequest())
        ->setProject($project)
        ->setProjectsSetDefaultNetworkTierRequestResource($projectsSetDefaultNetworkTierRequestResource);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $projectsClient->setDefaultNetworkTier($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $project = '[PROJECT]';

    set_default_network_tier_sample($project);
}
// [END compute_v1_generated_Projects_SetDefaultNetworkTier_sync]
