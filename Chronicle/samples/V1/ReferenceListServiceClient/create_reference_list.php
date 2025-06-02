<?php
/*
 * Copyright 2025 Google LLC
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

// [START chronicle_v1_generated_ReferenceListService_CreateReferenceList_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\ReferenceListServiceClient;
use Google\Cloud\Chronicle\V1\CreateReferenceListRequest;
use Google\Cloud\Chronicle\V1\ReferenceList;
use Google\Cloud\Chronicle\V1\ReferenceListEntry;
use Google\Cloud\Chronicle\V1\ReferenceListSyntaxType;

/**
 * Creates a new reference list.
 *
 * @param string $formattedParent           The parent resource where this reference list will be created.
 *                                          Format: `projects/{project}/locations/{location}/instances/{instance}`
 *                                          Please see {@see ReferenceListServiceClient::instanceName()} for help formatting this field.
 * @param string $referenceListDescription  A user-provided description of the reference list.
 * @param string $referenceListEntriesValue The value of the entry. Maximum length is 512 characters.
 * @param int    $referenceListSyntaxType   The syntax type indicating how list entries should be validated.
 * @param string $referenceListId           The ID to use for the reference list. This is also the display
 *                                          name for the reference list. It must satisfy the following requirements:
 *                                          - Starts with letter.
 *                                          - Contains only letters, numbers and underscore.
 *                                          - Has length less than 256.
 *                                          - Must be unique.
 */
function create_reference_list_sample(
    string $formattedParent,
    string $referenceListDescription,
    string $referenceListEntriesValue,
    int $referenceListSyntaxType,
    string $referenceListId
): void {
    // Create a client.
    $referenceListServiceClient = new ReferenceListServiceClient();

    // Prepare the request message.
    $referenceListEntry = (new ReferenceListEntry())
        ->setValue($referenceListEntriesValue);
    $referenceListEntries = [$referenceListEntry,];
    $referenceList = (new ReferenceList())
        ->setDescription($referenceListDescription)
        ->setEntries($referenceListEntries)
        ->setSyntaxType($referenceListSyntaxType);
    $request = (new CreateReferenceListRequest())
        ->setParent($formattedParent)
        ->setReferenceList($referenceList)
        ->setReferenceListId($referenceListId);

    // Call the API and handle any network failures.
    try {
        /** @var ReferenceList $response */
        $response = $referenceListServiceClient->createReferenceList($request);
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
    $formattedParent = ReferenceListServiceClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]'
    );
    $referenceListDescription = '[DESCRIPTION]';
    $referenceListEntriesValue = '[VALUE]';
    $referenceListSyntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
    $referenceListId = '[REFERENCE_LIST_ID]';

    create_reference_list_sample(
        $formattedParent,
        $referenceListDescription,
        $referenceListEntriesValue,
        $referenceListSyntaxType,
        $referenceListId
    );
}
// [END chronicle_v1_generated_ReferenceListService_CreateReferenceList_sync]
