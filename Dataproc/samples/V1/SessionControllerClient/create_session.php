<?php
/*
 * Copyright 2024 Google LLC
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

// [START dataproc_v1_generated_SessionController_CreateSession_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataproc\V1\Client\SessionControllerClient;
use Google\Cloud\Dataproc\V1\CreateSessionRequest;
use Google\Cloud\Dataproc\V1\Session;
use Google\Rpc\Status;

/**
 * Create an interactive session asynchronously.
 *
 * @param string $formattedParent The parent resource where this session will be created. Please see
 *                                {@see SessionControllerClient::locationName()} for help formatting this field.
 * @param string $sessionName     The resource name of the session.
 * @param string $sessionId       The ID to use for the session, which becomes the final component
 *                                of the session's resource name.
 *
 *                                This value must be 4-63 characters. Valid characters
 *                                are /[a-z][0-9]-/.
 */
function create_session_sample(
    string $formattedParent,
    string $sessionName,
    string $sessionId
): void {
    // Create a client.
    $sessionControllerClient = new SessionControllerClient();

    // Prepare the request message.
    $session = (new Session())
        ->setName($sessionName);
    $request = (new CreateSessionRequest())
        ->setParent($formattedParent)
        ->setSession($session)
        ->setSessionId($sessionId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $sessionControllerClient->createSession($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Session $result */
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
    $formattedParent = SessionControllerClient::locationName('[PROJECT]', '[LOCATION]');
    $sessionName = '[NAME]';
    $sessionId = '[SESSION_ID]';

    create_session_sample($formattedParent, $sessionName, $sessionId);
}
// [END dataproc_v1_generated_SessionController_CreateSession_sync]
