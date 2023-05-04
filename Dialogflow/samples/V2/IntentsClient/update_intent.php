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

// [START dialogflow_v2_generated_Intents_UpdateIntent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Intent;
use Google\Cloud\Dialogflow\V2\IntentsClient;

/**
 * Updates the specified intent.
 *
 * Note: You should always train an agent prior to sending it queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/es/docs/training).
 *
 * @param string $intentDisplayName The name of this intent.
 */
function update_intent_sample(string $intentDisplayName): void
{
    // Create a client.
    $intentsClient = new IntentsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $intent = (new Intent())
        ->setDisplayName($intentDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var Intent $response */
        $response = $intentsClient->updateIntent($intent);
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
    $intentDisplayName = '[DISPLAY_NAME]';

    update_intent_sample($intentDisplayName);
}
// [END dialogflow_v2_generated_Intents_UpdateIntent_sync]
