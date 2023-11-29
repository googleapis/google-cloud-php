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

// [START dialogflow_v3_generated_Environments_UpdateEnvironment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\Environment;
use Google\Cloud\Dialogflow\Cx\V3\EnvironmentsClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the specified
 * [Environment][google.cloud.dialogflow.cx.v3.Environment].
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`: An empty [Struct
 * message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#struct)
 * - `response`: [Environment][google.cloud.dialogflow.cx.v3.Environment]
 *
 * @param string $environmentDisplayName The human-readable name of the environment (unique in an agent).
 *                                       Limit of 64 characters.
 */
function update_environment_sample(string $environmentDisplayName): void
{
    // Create a client.
    $environmentsClient = new EnvironmentsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $environment = (new Environment())
        ->setDisplayName($environmentDisplayName);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $environmentsClient->updateEnvironment($environment, $updateMask);
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
    $environmentDisplayName = '[DISPLAY_NAME]';

    update_environment_sample($environmentDisplayName);
}
// [END dialogflow_v3_generated_Environments_UpdateEnvironment_sync]
