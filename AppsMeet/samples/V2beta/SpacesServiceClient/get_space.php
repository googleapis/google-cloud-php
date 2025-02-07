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

// [START meet_v2beta_generated_SpacesService_GetSpace_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Meet\V2beta\Client\SpacesServiceClient;
use Google\Apps\Meet\V2beta\GetSpaceRequest;
use Google\Apps\Meet\V2beta\Space;

/**
 * Gets details about a meeting space.
 *
 * For an example, see [Get a meeting
 * space](https://developers.google.com/meet/api/guides/meeting-spaces#get-meeting-space).
 *
 * @param string $formattedName Resource name of the space.
 *
 *                              Format: `spaces/{space}` or `spaces/{meetingCode}`.
 *
 *                              `{space}` is the resource identifier for the space. It's a unique,
 *                              server-generated ID and is case sensitive. For example, `jQCFfuBOdN5z`.
 *
 *                              `{meetingCode}` is an alias for the space. It's a typeable, unique
 *                              character string and is non-case sensitive. For example, `abc-mnop-xyz`.
 *                              The maximum length is 128 characters.
 *
 *                              A `meetingCode` shouldn't be stored long term as it can become
 *                              dissociated from a meeting space and can be reused for different meeting
 *                              spaces in the future. Generally, a `meetingCode` expires 365 days after
 *                              last use. For more information, see [Learn about meeting codes in Google
 *                              Meet](https://support.google.com/meet/answer/10710509).
 *
 *                              For more information, see [How Meet identifies a meeting
 *                              space](https://developers.google.com/meet/api/guides/meeting-spaces#identify-meeting-space). Please see
 *                              {@see SpacesServiceClient::spaceName()} for help formatting this field.
 */
function get_space_sample(string $formattedName): void
{
    // Create a client.
    $spacesServiceClient = new SpacesServiceClient();

    // Prepare the request message.
    $request = (new GetSpaceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $spacesServiceClient->getSpace($request);
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
    $formattedName = SpacesServiceClient::spaceName('[SPACE]');

    get_space_sample($formattedName);
}
// [END meet_v2beta_generated_SpacesService_GetSpace_sync]
