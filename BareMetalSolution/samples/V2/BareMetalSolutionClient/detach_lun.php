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

// [START baremetalsolution_v2_generated_BareMetalSolution_DetachLun_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BareMetalSolution\V2\BareMetalSolutionClient;
use Google\Cloud\BareMetalSolution\V2\Instance;
use Google\Rpc\Status;

/**
 * Detach LUN from Instance.
 *
 * @param string $formattedInstance Name of the instance. Please see
 *                                  {@see BareMetalSolutionClient::instanceName()} for help formatting this field.
 * @param string $formattedLun      Name of the Lun to detach. Please see
 *                                  {@see BareMetalSolutionClient::lunName()} for help formatting this field.
 */
function detach_lun_sample(string $formattedInstance, string $formattedLun): void
{
    // Create a client.
    $bareMetalSolutionClient = new BareMetalSolutionClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bareMetalSolutionClient->detachLun($formattedInstance, $formattedLun);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedInstance = BareMetalSolutionClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $formattedLun = BareMetalSolutionClient::lunName('[PROJECT]', '[LOCATION]', '[VOLUME]', '[LUN]');

    detach_lun_sample($formattedInstance, $formattedLun);
}
// [END baremetalsolution_v2_generated_BareMetalSolution_DetachLun_sync]
