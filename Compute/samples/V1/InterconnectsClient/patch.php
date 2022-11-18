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

// [START compute_v1_generated_Interconnects_Patch_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Interconnect;
use Google\Cloud\Compute\V1\InterconnectsClient;
use Google\Rpc\Status;

/**
 * Updates the specified interconnect with the data included in the request. This method supports PATCH semantics and uses the JSON merge patch format and processing rules.
 *
 * @param string $interconnect Name of the interconnect to update.
 * @param string $project      Project ID for this request.
 */
function patch_sample(string $interconnect, string $project): void
{
    // Create a client.
    $interconnectsClient = new InterconnectsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $interconnectResource = new Interconnect();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $interconnectsClient->patch($interconnect, $interconnectResource, $project);
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
    $interconnect = '[INTERCONNECT]';
    $project = '[PROJECT]';

    patch_sample($interconnect, $project);
}
// [END compute_v1_generated_Interconnects_Patch_sync]
