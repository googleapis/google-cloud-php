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

// [START dialogflow_v2_generated_ConversationModels_CreateConversationModelEvaluation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Client\ConversationModelsClient;
use Google\Cloud\Dialogflow\V2\ConversationModelEvaluation;
use Google\Cloud\Dialogflow\V2\CreateConversationModelEvaluationRequest;
use Google\Rpc\Status;

/**
 * Creates evaluation of a conversation model.
 *
 * @param string $formattedParent The conversation model resource name. Format:
 *                                `projects/<Project ID>/locations/<Location
 *                                ID>/conversationModels/<Conversation Model ID>`
 *                                Please see {@see ConversationModelsClient::conversationModelName()} for help formatting this field.
 */
function create_conversation_model_evaluation_sample(string $formattedParent): void
{
    // Create a client.
    $conversationModelsClient = new ConversationModelsClient();

    // Prepare the request message.
    $conversationModelEvaluation = new ConversationModelEvaluation();
    $request = (new CreateConversationModelEvaluationRequest())
        ->setParent($formattedParent)
        ->setConversationModelEvaluation($conversationModelEvaluation);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $conversationModelsClient->createConversationModelEvaluation($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ConversationModelEvaluation $result */
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
    $formattedParent = ConversationModelsClient::conversationModelName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONVERSATION_MODEL]'
    );

    create_conversation_model_evaluation_sample($formattedParent);
}
// [END dialogflow_v2_generated_ConversationModels_CreateConversationModelEvaluation_sync]
