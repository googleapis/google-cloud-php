<?php
/*
 * Copyright 2023 Google LLC
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

// [START notebooks_v1_generated_NotebookService_CreateEnvironment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Notebooks\V1\Client\NotebookServiceClient;
use Google\Cloud\Notebooks\V1\CreateEnvironmentRequest;
use Google\Cloud\Notebooks\V1\Environment;
use Google\Rpc\Status;

/**
 * Creates a new Environment.
 *
 * @param string $parent        Format: `projects/{project_id}/locations/{location}`
 * @param string $environmentId User-defined unique ID of this environment. The `environment_id` must
 *                              be 1 to 63 characters long and contain only lowercase letters,
 *                              numeric characters, and dashes. The first character must be a lowercase
 *                              letter and the last character cannot be a dash.
 */
function create_environment_sample(string $parent, string $environmentId): void
{
    // Create a client.
    $notebookServiceClient = new NotebookServiceClient();

    // Prepare the request message.
    $environment = new Environment();
    $request = (new CreateEnvironmentRequest())
        ->setParent($parent)
        ->setEnvironmentId($environmentId)
        ->setEnvironment($environment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $notebookServiceClient->createEnvironment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Environment $result */
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
    $environmentId = '[ENVIRONMENT_ID]';

    create_environment_sample($parent, $environmentId);
}
// [END notebooks_v1_generated_NotebookService_CreateEnvironment_sync]
