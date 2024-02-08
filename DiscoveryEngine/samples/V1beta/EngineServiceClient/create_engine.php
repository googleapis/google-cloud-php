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

// [START discoveryengine_v1beta_generated_EngineService_CreateEngine_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\EngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\CreateEngineRequest;
use Google\Cloud\DiscoveryEngine\V1beta\Engine;
use Google\Cloud\DiscoveryEngine\V1beta\SolutionType;
use Google\Rpc\Status;

/**
 * Creates a [Engine][google.cloud.discoveryengine.v1beta.Engine].
 *
 * @param string $formattedParent    The parent resource name, such as
 *                                   `projects/{project}/locations/{location}/collections/{collection}`. Please see
 *                                   {@see EngineServiceClient::collectionName()} for help formatting this field.
 * @param string $engineDisplayName  The display name of the engine. Should be human readable. UTF-8
 *                                   encoded string with limit of 1024 characters.
 * @param int    $engineSolutionType The solutions of the engine.
 * @param string $engineId           The ID to use for the
 *                                   [Engine][google.cloud.discoveryengine.v1beta.Engine], which will become the
 *                                   final component of the
 *                                   [Engine][google.cloud.discoveryengine.v1beta.Engine]'s resource name.
 *
 *                                   This field must conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
 *                                   standard with a length limit of 63 characters. Otherwise, an
 *                                   INVALID_ARGUMENT error is returned.
 */
function create_engine_sample(
    string $formattedParent,
    string $engineDisplayName,
    int $engineSolutionType,
    string $engineId
): void {
    // Create a client.
    $engineServiceClient = new EngineServiceClient();

    // Prepare the request message.
    $engine = (new Engine())
        ->setDisplayName($engineDisplayName)
        ->setSolutionType($engineSolutionType);
    $request = (new CreateEngineRequest())
        ->setParent($formattedParent)
        ->setEngine($engine)
        ->setEngineId($engineId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $engineServiceClient->createEngine($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Engine $result */
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
    $formattedParent = EngineServiceClient::collectionName('[PROJECT]', '[LOCATION]', '[COLLECTION]');
    $engineDisplayName = '[DISPLAY_NAME]';
    $engineSolutionType = SolutionType::SOLUTION_TYPE_UNSPECIFIED;
    $engineId = '[ENGINE_ID]';

    create_engine_sample($formattedParent, $engineDisplayName, $engineSolutionType, $engineId);
}
// [END discoveryengine_v1beta_generated_EngineService_CreateEngine_sync]
