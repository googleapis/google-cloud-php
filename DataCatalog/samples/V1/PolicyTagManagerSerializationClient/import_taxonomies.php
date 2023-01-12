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

// [START datacatalog_v1_generated_PolicyTagManagerSerialization_ImportTaxonomies_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\ImportTaxonomiesResponse;
use Google\Cloud\DataCatalog\V1\PolicyTagManagerSerializationClient;

/**
 * Creates new taxonomies (including their policy tags) in a given project
 * by importing from inlined or cross-regional sources.
 *
 * For a cross-regional source, new taxonomies are created by copying
 * from a source in another region.
 *
 * For an inlined source, taxonomies and policy tags are created in bulk using
 * nested protocol buffer structures.
 *
 * @param string $formattedParent Resource name of project that the imported taxonomies will belong to. Please see
 *                                {@see PolicyTagManagerSerializationClient::locationName()} for help formatting this field.
 */
function import_taxonomies_sample(string $formattedParent): void
{
    // Create a client.
    $policyTagManagerSerializationClient = new PolicyTagManagerSerializationClient();

    // Call the API and handle any network failures.
    try {
        /** @var ImportTaxonomiesResponse $response */
        $response = $policyTagManagerSerializationClient->importTaxonomies($formattedParent);
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
    $formattedParent = PolicyTagManagerSerializationClient::locationName('[PROJECT]', '[LOCATION]');

    import_taxonomies_sample($formattedParent);
}
// [END datacatalog_v1_generated_PolicyTagManagerSerialization_ImportTaxonomies_sync]
