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

// [START datacatalog_v1_generated_PolicyTagManagerSerialization_ReplaceTaxonomy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\PolicyTagManagerSerializationClient;
use Google\Cloud\DataCatalog\V1\SerializedTaxonomy;
use Google\Cloud\DataCatalog\V1\Taxonomy;

/**
 * Replaces (updates) a taxonomy and all its policy tags.
 *
 * The taxonomy and its entire hierarchy of policy tags must be
 * represented literally by `SerializedTaxonomy` and the nested
 * `SerializedPolicyTag` messages.
 *
 * This operation automatically does the following:
 *
 * - Deletes the existing policy tags that are missing from the
 * `SerializedPolicyTag`.
 * - Creates policy tags that don't have resource names. They are considered
 * new.
 * - Updates policy tags with valid resources names accordingly.
 *
 * @param string $formattedName                 Resource name of the taxonomy to update. Please see
 *                                              {@see PolicyTagManagerSerializationClient::taxonomyName()} for help formatting this field.
 * @param string $serializedTaxonomyDisplayName Display name of the taxonomy. At most 200 bytes when encoded in UTF-8.
 */
function replace_taxonomy_sample(
    string $formattedName,
    string $serializedTaxonomyDisplayName
): void {
    // Create a client.
    $policyTagManagerSerializationClient = new PolicyTagManagerSerializationClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $serializedTaxonomy = (new SerializedTaxonomy())
        ->setDisplayName($serializedTaxonomyDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var Taxonomy $response */
        $response = $policyTagManagerSerializationClient->replaceTaxonomy(
            $formattedName,
            $serializedTaxonomy
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
    $formattedName = PolicyTagManagerSerializationClient::taxonomyName(
        '[PROJECT]',
        '[LOCATION]',
        '[TAXONOMY]'
    );
    $serializedTaxonomyDisplayName = '[DISPLAY_NAME]';

    replace_taxonomy_sample($formattedName, $serializedTaxonomyDisplayName);
}
// [END datacatalog_v1_generated_PolicyTagManagerSerialization_ReplaceTaxonomy_sync]
