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

// [START designcenter_v1_generated_DesignCenter_CreateSpace_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DesignCenter\V1\Client\DesignCenterClient;
use Google\Cloud\DesignCenter\V1\CreateSpaceRequest;
use Google\Cloud\DesignCenter\V1\Space;

/**
 * Creates a space.
 *
 * @param string $formattedParent The parent in which to create a space. Please see
 *                                {@see DesignCenterClient::locationName()} for help formatting this field.
 * @param string $spaceId         The ID of the space to create.
 */
function create_space_sample(string $formattedParent, string $spaceId): void
{
    // Create a client.
    $designCenterClient = new DesignCenterClient();

    // Prepare the request message.
    $space = new Space();
    $request = (new CreateSpaceRequest())
        ->setParent($formattedParent)
        ->setSpaceId($spaceId)
        ->setSpace($space);

    // Call the API and handle any network failures.
    try {
        /** @var Space $response */
        $response = $designCenterClient->createSpace($request);
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
    $formattedParent = DesignCenterClient::locationName('[PROJECT]', '[LOCATION]');
    $spaceId = '[SPACE_ID]';

    create_space_sample($formattedParent, $spaceId);
}
// [END designcenter_v1_generated_DesignCenter_CreateSpace_sync]
