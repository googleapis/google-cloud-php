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

// [START dialogflow_v2_generated_Agents_ExportAgent_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\AgentsClient;
use Google\Cloud\Dialogflow\V2\ExportAgentResponse;
use Google\Rpc\Status;

/**
 * Exports the specified agent to a ZIP file.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`: An empty [Struct
 * message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#struct)
 * - `response`:
 * [ExportAgentResponse][google.cloud.dialogflow.v2.ExportAgentResponse]
 *
 * @param string $formattedParent The project that the agent to export is associated with.
 *                                Format: `projects/<Project ID>`. Please see
 *                                {@see AgentsClient::projectName()} for help formatting this field.
 * @param string $agentUri        The [Google Cloud
 *                                Storage](https://cloud.google.com/storage/docs/) URI to export the agent
 *                                to. The format of this URI must be `gs://<bucket-name>/<object-name>`. If
 *                                left unspecified, the serialized agent is returned inline.
 *
 *                                Dialogflow performs a write operation for the Cloud Storage object
 *                                on the caller's behalf, so your request authentication must
 *                                have write permissions for the object. For more information, see
 *                                [Dialogflow access
 *                                control](https://cloud.google.com/dialogflow/cx/docs/concept/access-control#storage).
 */
function export_agent_sample(string $formattedParent, string $agentUri): void
{
    // Create a client.
    $agentsClient = new AgentsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $agentsClient->exportAgent($formattedParent, $agentUri);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportAgentResponse $result */
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
    $formattedParent = AgentsClient::projectName('[PROJECT]');
    $agentUri = '[AGENT_URI]';

    export_agent_sample($formattedParent, $agentUri);
}
// [END dialogflow_v2_generated_Agents_ExportAgent_sync]
