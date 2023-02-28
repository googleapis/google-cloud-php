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

// [START dialogflow_v2_generated_ConversationDatasets_DeleteConversationDataset_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\ConversationDatasetsClient;
use Google\Rpc\Status;

/**
 * Deletes the specified conversation dataset.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`: [DeleteConversationDatasetOperationMetadata][google.cloud.dialogflow.v2.DeleteConversationDatasetOperationMetadata]
 * - `response`: An [Empty
 * message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
 *
 * @param string $formattedName The conversation dataset to delete. Format:
 *                              `projects/<Project ID>/locations/<Location
 *                              ID>/conversationDatasets/<Conversation Dataset ID>`
 *                              Please see {@see ConversationDatasetsClient::conversationDatasetName()} for help formatting this field.
 */
function delete_conversation_dataset_sample(string $formattedName): void
{
    // Create a client.
    $conversationDatasetsClient = new ConversationDatasetsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $conversationDatasetsClient->deleteConversationDataset($formattedName);
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
    $formattedName = ConversationDatasetsClient::conversationDatasetName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSATION_DATASET]'
    );

    delete_conversation_dataset_sample($formattedName);
}
// [END dialogflow_v2_generated_ConversationDatasets_DeleteConversationDataset_sync]
