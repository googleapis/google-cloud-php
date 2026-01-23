<?php
/*
 * Copyright 2026 Google LLC
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

// [START dialogflow_v3_generated_Examples_UpdateExample_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Action;
use Google\Cloud\Dialogflow\Cx\V3\Client\ExamplesClient;
use Google\Cloud\Dialogflow\Cx\V3\Example;
use Google\Cloud\Dialogflow\Cx\V3\OutputState;
use Google\Cloud\Dialogflow\Cx\V3\UpdateExampleRequest;

/**
 * Update the specified example.
 *
 * @param string $exampleDisplayName       The display name of the example.
 * @param int    $exampleConversationState Example's output state.
 */
function update_example_sample(string $exampleDisplayName, int $exampleConversationState): void
{
    // Create a client.
    $examplesClient = new ExamplesClient();

    // Prepare the request message.
    $exampleActions = [new Action()];
    $example = (new Example())
        ->setActions($exampleActions)
        ->setDisplayName($exampleDisplayName)
        ->setConversationState($exampleConversationState);
    $request = (new UpdateExampleRequest())
        ->setExample($example);

    // Call the API and handle any network failures.
    try {
        /** @var Example $response */
        $response = $examplesClient->updateExample($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $exampleDisplayName = '[DISPLAY_NAME]';
    $exampleConversationState = OutputState::OUTPUT_STATE_UNSPECIFIED;

    update_example_sample($exampleDisplayName, $exampleConversationState);
}
// [END dialogflow_v3_generated_Examples_UpdateExample_sync]
