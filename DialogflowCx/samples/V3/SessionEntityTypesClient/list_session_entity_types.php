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

// [START dialogflow_v3_generated_SessionEntityTypes_ListSessionEntityTypes_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dialogflow\Cx\V3\Client\SessionEntityTypesClient;
use Google\Cloud\Dialogflow\Cx\V3\ListSessionEntityTypesRequest;
use Google\Cloud\Dialogflow\Cx\V3\SessionEntityType;

/**
 * Returns the list of all session entity types in the specified session.
 *
 * @param string $formattedParent The session to list all session entity types from.
 *                                Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent
 *                                ID>/sessions/<Session ID>` or `projects/<Project ID>/locations/<Location
 *                                ID>/agents/<Agent ID>/environments/<Environment ID>/sessions/<Session ID>`.
 *                                If `Environment ID` is not specified, we assume default 'draft'
 *                                environment. Please see
 *                                {@see SessionEntityTypesClient::sessionName()} for help formatting this field.
 */
function list_session_entity_types_sample(string $formattedParent): void
{
    // Create a client.
    $sessionEntityTypesClient = new SessionEntityTypesClient();

    // Prepare the request message.
    $request = (new ListSessionEntityTypesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $sessionEntityTypesClient->listSessionEntityTypes($request);

        /** @var SessionEntityType $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = SessionEntityTypesClient::sessionName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[SESSION]'
    );

    list_session_entity_types_sample($formattedParent);
}
// [END dialogflow_v3_generated_SessionEntityTypes_ListSessionEntityTypes_sync]
