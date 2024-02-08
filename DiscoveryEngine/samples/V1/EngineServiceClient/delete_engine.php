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

// [START discoveryengine_v1_generated_EngineService_DeleteEngine_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\EngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DeleteEngineRequest;
use Google\Rpc\Status;

/**
 * Deletes a [Engine][google.cloud.discoveryengine.v1.Engine].
 *
 * @param string $formattedName Full resource name of
 *                              [Engine][google.cloud.discoveryengine.v1.Engine], such as
 *                              `projects/{project}/locations/{location}/collections/{collection_id}/engines/{engine_id}`.
 *
 *                              If the caller does not have permission to delete the
 *                              [Engine][google.cloud.discoveryengine.v1.Engine], regardless of whether or
 *                              not it exists, a PERMISSION_DENIED error is returned.
 *
 *                              If the [Engine][google.cloud.discoveryengine.v1.Engine] to delete does not
 *                              exist, a NOT_FOUND error is returned. Please see
 *                              {@see EngineServiceClient::engineName()} for help formatting this field.
 */
function delete_engine_sample(string $formattedName): void
{
    // Create a client.
    $engineServiceClient = new EngineServiceClient();

    // Prepare the request message.
    $request = (new DeleteEngineRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $engineServiceClient->deleteEngine($request);
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
    $formattedName = EngineServiceClient::engineName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]',
        '[ENGINE]'
    );

    delete_engine_sample($formattedName);
}
// [END discoveryengine_v1_generated_EngineService_DeleteEngine_sync]
