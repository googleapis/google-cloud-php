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

// [START chronicle_v1_generated_ReferenceListService_VerifyReferenceList_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\ReferenceListServiceClient;
use Google\Cloud\Chronicle\V1\ReferenceListEntry;
use Google\Cloud\Chronicle\V1\ReferenceListSyntaxType;
use Google\Cloud\Chronicle\V1\VerifyReferenceListRequest;
use Google\Cloud\Chronicle\V1\VerifyReferenceListResponse;

/**
 * VerifyReferenceList validates list content and returns line errors, if any.
 *
 * @param string $formattedInstance The name of the parent resource, which is the SecOps instance
 *                                  associated with the request. Format:
 *                                  `projects/{project}/locations/{location}/instances/{instance}`
 *                                  Please see {@see ReferenceListServiceClient::instanceName()} for help formatting this field.
 * @param int    $syntaxType        Type (format) of list lines.
 * @param string $entriesValue      The value of the entry. Maximum length is 512 characters.
 */
function verify_reference_list_sample(
    string $formattedInstance,
    int $syntaxType,
    string $entriesValue
): void {
    // Create a client.
    $referenceListServiceClient = new ReferenceListServiceClient();

    // Prepare the request message.
    $referenceListEntry = (new ReferenceListEntry())
        ->setValue($entriesValue);
    $entries = [$referenceListEntry,];
    $request = (new VerifyReferenceListRequest())
        ->setInstance($formattedInstance)
        ->setSyntaxType($syntaxType)
        ->setEntries($entries);

    // Call the API and handle any network failures.
    try {
        /** @var VerifyReferenceListResponse $response */
        $response = $referenceListServiceClient->verifyReferenceList($request);
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
    $formattedInstance = ReferenceListServiceClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]'
    );
    $syntaxType = ReferenceListSyntaxType::REFERENCE_LIST_SYNTAX_TYPE_UNSPECIFIED;
    $entriesValue = '[VALUE]';

    verify_reference_list_sample($formattedInstance, $syntaxType, $entriesValue);
}
// [END chronicle_v1_generated_ReferenceListService_VerifyReferenceList_sync]
