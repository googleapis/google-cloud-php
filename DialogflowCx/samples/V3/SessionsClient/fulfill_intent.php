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

// [START dialogflow_v3_generated_Sessions_FulfillIntent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\FulfillIntentResponse;
use Google\Cloud\Dialogflow\Cx\V3\SessionsClient;

/**
 * Fulfills a matched intent returned by
 * [MatchIntent][google.cloud.dialogflow.cx.v3.Sessions.MatchIntent]. Must be
 * called after
 * [MatchIntent][google.cloud.dialogflow.cx.v3.Sessions.MatchIntent], with
 * input from
 * [MatchIntentResponse][google.cloud.dialogflow.cx.v3.MatchIntentResponse].
 * Otherwise, the behavior is undefined.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function fulfill_intent_sample(): void
{
    // Create a client.
    $sessionsClient = new SessionsClient();

    // Call the API and handle any network failures.
    try {
        /** @var FulfillIntentResponse $response */
        $response = $sessionsClient->fulfillIntent();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END dialogflow_v3_generated_Sessions_FulfillIntent_sync]
