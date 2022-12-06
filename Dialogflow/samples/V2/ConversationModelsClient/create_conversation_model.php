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

// [START dialogflow_v2_generated_ConversationModels_CreateConversationModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\ConversationModel;
use Google\Cloud\Dialogflow\V2\ConversationModelsClient;
use Google\Cloud\Dialogflow\V2\InputDataset;
use Google\Rpc\Status;

/**
 * Creates a model.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`: [CreateConversationModelOperationMetadata][google.cloud.dialogflow.v2.CreateConversationModelOperationMetadata]
 * - `response`: [ConversationModel][google.cloud.dialogflow.v2.ConversationModel]
 *
 * @param string $conversationModelDisplayName              The display name of the model. At most 64 bytes long.
 * @param string $formattedConversationModelDatasetsDataset ConversationDataset resource name. Format:
 *                                                          `projects/<Project ID>/locations/<Location
 *                                                          ID>/conversationDatasets/<Conversation Dataset ID>`
 *                                                          Please see {@see ConversationModelsClient::conversationDatasetName()} for help formatting this field.
 */
function create_conversation_model_sample(
    string $conversationModelDisplayName,
    string $formattedConversationModelDatasetsDataset
): void {
    // Create a client.
    $conversationModelsClient = new ConversationModelsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputDataset = (new InputDataset())
        ->setDataset($formattedConversationModelDatasetsDataset);
    $conversationModelDatasets = [$inputDataset,];
    $conversationModel = (new ConversationModel())
        ->setDisplayName($conversationModelDisplayName)
        ->setDatasets($conversationModelDatasets);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $conversationModelsClient->createConversationModel($conversationModel);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ConversationModel $result */
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
    $conversationModelDisplayName = '[DISPLAY_NAME]';
    $formattedConversationModelDatasetsDataset = ConversationModelsClient::conversationDatasetName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSATION_DATASET]'
    );

    create_conversation_model_sample(
        $conversationModelDisplayName,
        $formattedConversationModelDatasetsDataset
    );
}
// [END dialogflow_v2_generated_ConversationModels_CreateConversationModel_sync]
