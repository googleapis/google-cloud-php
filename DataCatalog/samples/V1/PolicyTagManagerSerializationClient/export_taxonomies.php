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
use Google\Cloud\DataCatalog\V1\Client\PolicyTagManagerSerializationClient;
use Google\Cloud\DataCatalog\V1\ExportTaxonomiesRequest;
use Google\Cloud\DataCatalog\V1\ExportTaxonomiesResponse;

/**
 * Exports taxonomies in the requested type and returns them,
 * including their policy tags. The requested taxonomies must belong to the
 * same project.
 *
 * This method generates `SerializedTaxonomy` protocol buffers with nested
 * policy tags that can be used as input for `ImportTaxonomies` calls.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function export_taxonomies_sample(): void
{
    // Create a client.
    $policyTagManagerSerializationClient = new PolicyTagManagerSerializationClient();

    // Prepare the request message.
    $request = new ExportTaxonomiesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var ExportTaxonomiesResponse $response */
        $response = $policyTagManagerSerializationClient->exportTaxonomies($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END datacatalog_v1_generated_PolicyTagManagerSerialization_ExportTaxonomies_sync]
