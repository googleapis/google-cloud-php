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

// [START meet_v2beta_generated_SpacesService_EndActiveConference_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Meet\V2beta\Client\SpacesServiceClient;
use Google\Apps\Meet\V2beta\EndActiveConferenceRequest;

/**
 * [Developer Preview](https://developers.google.com/workspace/preview).
 * Ends an active conference (if there is one).
 *
 * @param string $formattedName Resource name of the space. Please see
 *                              {@see SpacesServiceClient::spaceName()} for help formatting this field.
 */
function end_active_conference_sample(string $formattedName): void
{
    // Create a client.
    $spacesServiceClient = new SpacesServiceClient();

    // Prepare the request message.
    $request = (new EndActiveConferenceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $spacesServiceClient->endActiveConference($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = SpacesServiceClient::spaceName('[SPACE]');

    end_active_conference_sample($formattedName);
}
// [END meet_v2beta_generated_SpacesService_EndActiveConference_sync]
