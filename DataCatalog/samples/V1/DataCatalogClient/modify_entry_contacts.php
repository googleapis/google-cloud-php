<?php
/*
 * Copyright 2022 Google LLC
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

// [START datacatalog_v1_generated_DataCatalog_ModifyEntryContacts_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\Contacts;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;

/**
 * Modifies contacts, part of the business context of an
 * [Entry][google.cloud.datacatalog.v1.Entry].
 *
 * To call this method, you must have the `datacatalog.entries.updateContacts`
 * IAM permission on the corresponding project.
 *
 * @param string $formattedName The full resource name of the entry. Please see
 *                              {@see DataCatalogClient::entryName()} for help formatting this field.
 */
function modify_entry_contacts_sample(string $formattedName): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $contacts = new Contacts();

    // Call the API and handle any network failures.
    try {
        /** @var Contacts $response */
        $response = $dataCatalogClient->modifyEntryContacts($formattedName, $contacts);
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
    $formattedName = DataCatalogClient::entryName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENTRY_GROUP]',
        '[ENTRY]'
    );

    modify_entry_contacts_sample($formattedName);
}
// [END datacatalog_v1_generated_DataCatalog_ModifyEntryContacts_sync]
