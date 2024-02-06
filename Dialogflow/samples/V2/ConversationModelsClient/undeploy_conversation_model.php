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

// [START dialogflow_v2_generated_ConversationModels_UndeployConversationModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Client\ConversationModelsClient;
use Google\Cloud\Dialogflow\V2\UndeployConversationModelRequest;
use Google\Rpc\Status;

/**
 * Undeploys a model. If the model is not deployed this method has no effect.
 * If the model is currently being used:
 * - For article suggestion, article suggestion will fallback to the default
 * model if model is undeployed.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [UndeployConversationModelOperationMetadata][google.cloud.dialogflow.v2.UndeployConversationModelOperationMetadata]
 * - `response`: An [Empty
 * message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
 *
 * @param string $name The conversation model to undeploy. Format:
 *                     `projects/<Project ID>/conversationModels/<Conversation Model ID>`
 */
function undeploy_conversation_model_sample(string $name): void
{
    // Create a client.
    $conversationModelsClient = new ConversationModelsClient();

    // Prepare the request message.
    $request = (new UndeployConversationModelRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $conversationModelsClient->undeployConversationModel($request);
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
    $name = '[NAME]';

    undeploy_conversation_model_sample($name);
}
// [END dialogflow_v2_generated_ConversationModels_UndeployConversationModel_sync]
