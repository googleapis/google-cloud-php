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

// [START datacatalog_v1_generated_PolicyTagManagerSerialization_ExportTaxonomies_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\ExportTaxonomiesResponse;
use Google\Cloud\DataCatalog\V1\PolicyTagManagerSerializationClient;

/**
 * Exports taxonomies in the requested type and returns them,
 * including their policy tags. The requested taxonomies must belong to the
 * same project.
 *
 * This method generates `SerializedTaxonomy` protocol buffers with nested
 * policy tags that can be used as input for `ImportTaxonomies` calls.
 *
 * @param string $formattedParent            Resource name of the project that the exported taxonomies belong to. Please see
 *                                           {@see PolicyTagManagerSerializationClient::locationName()} for help formatting this field.
 * @param string $formattedTaxonomiesElement Resource names of the taxonomies to export. Please see
 *                                           {@see PolicyTagManagerSerializationClient::taxonomyName()} for help formatting this field.
 */
function export_taxonomies_sample(
    string $formattedParent,
    string $formattedTaxonomiesElement
): void {
    // Create a client.
    $policyTagManagerSerializationClient = new PolicyTagManagerSerializationClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedTaxonomies = [$formattedTaxonomiesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var ExportTaxonomiesResponse $response */
        $response = $policyTagManagerSerializationClient->exportTaxonomies(
            $formattedParent,
            $formattedTaxonomies
        );
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
    $formattedTaxonomiesElement = PolicyTagManagerSerializationClient::taxonomyName(
        '[PROJECT]',
        '[LOCATION]',
        '[TAXONOMY]'
    );

    export_taxonomies_sample($formattedParent, $formattedTaxonomiesElement);
}
// [END datacatalog_v1_generated_PolicyTagManagerSerialization_ExportTaxonomies_sync]
