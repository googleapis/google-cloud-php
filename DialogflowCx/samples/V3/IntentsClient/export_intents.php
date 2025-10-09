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

// [START dialogflow_v3_generated_Intents_ExportIntents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\Client\IntentsClient;
use Google\Cloud\Dialogflow\Cx\V3\ExportIntentsRequest;
use Google\Cloud\Dialogflow\Cx\V3\ExportIntentsResponse;
use Google\Rpc\Status;

/**
 * Exports the selected intents.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [ExportIntentsMetadata][google.cloud.dialogflow.cx.v3.ExportIntentsMetadata]
 * - `response`:
 * [ExportIntentsResponse][google.cloud.dialogflow.cx.v3.ExportIntentsResponse]
 *
 * @param string $formattedParent The name of the parent agent to export intents.
 *                                Format: `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>`. Please see
 *                                {@see IntentsClient::agentName()} for help formatting this field.
 * @param string $intentsElement  The name of the intents to export.
 *                                Format:
 *                                `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/intents/<IntentID>`.
 */
function export_intents_sample(string $formattedParent, string $intentsElement): void
{
    // Create a client.
    $intentsClient = new IntentsClient();

    // Prepare the request message.
    $intents = [$intentsElement,];
    $request = (new ExportIntentsRequest())
        ->setParent($formattedParent)
        ->setIntents($intents);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $intentsClient->exportIntents($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportIntentsResponse $result */
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
    $intentsElement = '[INTENTS]';

    export_intents_sample($formattedParent, $intentsElement);
}
// [END dialogflow_v3_generated_Intents_ExportIntents_sync]
