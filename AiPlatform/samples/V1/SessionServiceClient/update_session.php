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

// [START aiplatform_v1_generated_SessionService_UpdateSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\SessionServiceClient;
use Google\Cloud\AIPlatform\V1\Session;
use Google\Cloud\AIPlatform\V1\UpdateSessionRequest;

/**
 * Updates the specific [Session][google.cloud.aiplatform.v1.Session].
 *
 * @param string $sessionUserId Immutable. String id provided by the user
 */
function update_session_sample(string $sessionUserId): void
{
    // Create a client.
    $sessionServiceClient = new SessionServiceClient();

    // Prepare the request message.
    $session = (new Session())
        ->setUserId($sessionUserId);
    $request = (new UpdateSessionRequest())
        ->setSession($session);

    // Call the API and handle any network failures.
    try {
        /** @var Session $response */
        $response = $sessionServiceClient->updateSession($request);
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
    $sessionUserId = '[USER_ID]';

    update_session_sample($sessionUserId);
}
// [END aiplatform_v1_generated_SessionService_UpdateSession_sync]
