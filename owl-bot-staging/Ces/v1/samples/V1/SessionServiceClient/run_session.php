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

// [START ces_v1_generated_SessionService_RunSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Ces\V1\Client\SessionServiceClient;
use Google\Cloud\Ces\V1\RunSessionRequest;
use Google\Cloud\Ces\V1\RunSessionResponse;
use Google\Cloud\Ces\V1\SessionConfig;
use Google\Cloud\Ces\V1\SessionInput;

/**
 * Initiates a single turn interaction with the CES agent within a
 * session.
 *
 * @param string $formattedConfigSession The unique identifier of the session.
 *                                       Format:
 *                                       `projects/{project}/locations/{location}/apps/{app}/sessions/{session}`
 *                                       Please see {@see SessionServiceClient::sessionName()} for help formatting this field.
 */
function run_session_sample(string $formattedConfigSession): void
{
    // Create a client.
    $sessionServiceClient = new SessionServiceClient();

    // Prepare the request message.
    $config = (new SessionConfig())
        ->setSession($formattedConfigSession);
    $inputs = [new SessionInput()];
    $request = (new RunSessionRequest())
        ->setConfig($config)
        ->setInputs($inputs);

    // Call the API and handle any network failures.
    try {
        /** @var RunSessionResponse $response */
        $response = $sessionServiceClient->runSession($request);
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
    $formattedConfigSession = SessionServiceClient::sessionName(
        '[PROJECT]',
        '[LOCATION]',
        '[APP]',
        '[SESSION]'
    );

    run_session_sample($formattedConfigSession);
}
// [END ces_v1_generated_SessionService_RunSession_sync]
