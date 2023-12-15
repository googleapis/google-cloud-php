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

// [START dialogflow_v3_generated_Intents_ImportIntents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\ImportIntentsResponse;
use Google\Cloud\Dialogflow\Cx\V3\IntentsClient;
use Google\Rpc\Status;

/**
 * Imports the specified intents into the agent.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [ImportIntentsMetadata][google.cloud.dialogflow.cx.v3.ImportIntentsMetadata]
 * - `response`:
 * [ImportIntentsResponse][google.cloud.dialogflow.cx.v3.ImportIntentsResponse]
 *
 * @param string $formattedParent The agent to import the intents into.
 *                                Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>`. Please see
 *                                {@see IntentsClient::agentName()} for help formatting this field.
 */
function import_intents_sample(string $formattedParent): void
{
    // Create a client.
    $intentsClient = new IntentsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $intentsClient->importIntents($formattedParent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportIntentsResponse $result */
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
    $formattedParent = IntentsClient::agentName('[PROJECT]', '[LOCATION]', '[AGENT]');

    import_intents_sample($formattedParent);
}
// [END dialogflow_v3_generated_Intents_ImportIntents_sync]
