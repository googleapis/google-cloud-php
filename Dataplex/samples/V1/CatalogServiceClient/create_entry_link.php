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

// [START dataplex_v1_generated_CatalogService_CreateEntryLink_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\CreateEntryLinkRequest;
use Google\Cloud\Dataplex\V1\EntryLink;
use Google\Cloud\Dataplex\V1\EntryLink\EntryReference;
use Google\Cloud\Dataplex\V1\EntryLink\EntryReference\Type;

/**
 * Creates an Entry Link.
 *
 * @param string $formattedParent              The resource name of the parent Entry Group:
 *                                             `projects/{project_id_or_number}/locations/{location_id}/entryGroups/{entry_group_id}`. Please see
 *                                             {@see CatalogServiceClient::entryGroupName()} for help formatting this field.
 * @param string $entryLinkId                  Entry Link identifier
 *                                             * Must contain only lowercase letters, numbers and hyphens.
 *                                             * Must start with a letter.
 *                                             * Must be between 1-63 characters.
 *                                             * Must end with a number or a letter.
 *                                             * Must be unique within the EntryGroup.
 * @param string $entryLinkEntryLinkType       Immutable. Relative resource name of the Entry Link Type used to
 *                                             create this Entry Link. For example:
 *
 *                                             - Entry link between synonym terms in a glossary:
 *                                             `projects/dataplex-types/locations/global/entryLinkTypes/synonym`
 *                                             - Entry link between related terms in a glossary:
 *                                             `projects/dataplex-types/locations/global/entryLinkTypes/related`
 *                                             - Entry link between glossary terms and data assets:
 *                                             `projects/dataplex-types/locations/global/entryLinkTypes/definition`
 * @param string $entryLinkEntryReferencesName Immutable. The relative resource name of the referenced Entry,
 *                                             of the form:
 *                                             `projects/{project_id_or_number}/locations/{location_id}/entryGroups/{entry_group_id}/entries/{entry_id}`
 * @param int    $entryLinkEntryReferencesType Immutable. The reference type of the Entry.
 */
function create_entry_link_sample(
    string $formattedParent,
    string $entryLinkId,
    string $entryLinkEntryLinkType,
    string $entryLinkEntryReferencesName,
    int $entryLinkEntryReferencesType
): void {
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $entryReference = (new EntryReference())
        ->setName($entryLinkEntryReferencesName)
        ->setType($entryLinkEntryReferencesType);
    $entryLinkEntryReferences = [$entryReference,];
    $entryLink = (new EntryLink())
        ->setEntryLinkType($entryLinkEntryLinkType)
        ->setEntryReferences($entryLinkEntryReferences);
    $request = (new CreateEntryLinkRequest())
        ->setParent($formattedParent)
        ->setEntryLinkId($entryLinkId)
        ->setEntryLink($entryLink);

    // Call the API and handle any network failures.
    try {
        /** @var EntryLink $response */
        $response = $catalogServiceClient->createEntryLink($request);
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
    $formattedParent = CatalogServiceClient::entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
    $entryLinkId = '[ENTRY_LINK_ID]';
    $entryLinkEntryLinkType = '[ENTRY_LINK_TYPE]';
    $entryLinkEntryReferencesName = '[NAME]';
    $entryLinkEntryReferencesType = Type::UNSPECIFIED;

    create_entry_link_sample(
        $formattedParent,
        $entryLinkId,
        $entryLinkEntryLinkType,
        $entryLinkEntryReferencesName,
        $entryLinkEntryReferencesType
    );
}
// [END dataplex_v1_generated_CatalogService_CreateEntryLink_sync]
