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

// [START notebooks_v1_generated_NotebookService_RegisterInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Notebooks\V1\Client\NotebookServiceClient;
use Google\Cloud\Notebooks\V1\Instance;
use Google\Cloud\Notebooks\V1\RegisterInstanceRequest;
use Google\Rpc\Status;

/**
 * Registers an existing legacy notebook instance to the Notebooks API server.
 * Legacy instances are instances created with the legacy Compute Engine
 * calls. They are not manageable by the Notebooks API out of the box. This
 * call makes these instances manageable by the Notebooks API.
 *
 * @param string $parent     Format:
 *                           `parent=projects/{project_id}/locations/{location}`
 * @param string $instanceId User defined unique ID of this instance. The `instance_id` must
 *                           be 1 to 63 characters long and contain only lowercase letters,
 *                           numeric characters, and dashes. The first character must be a lowercase
 *                           letter and the last character cannot be a dash.
 */
function register_instance_sample(string $parent, string $instanceId): void
{
    // Create a client.
    $notebookServiceClient = new NotebookServiceClient();

    // Prepare the request message.
    $request = (new RegisterInstanceRequest())
        ->setParent($parent)
        ->setInstanceId($instanceId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $notebookServiceClient->registerInstance($request);
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
    $parent = '[PARENT]';
    $instanceId = '[INSTANCE_ID]';

    register_instance_sample($parent, $instanceId);
}
// [END notebooks_v1_generated_NotebookService_RegisterInstance_sync]
