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

// [START retail_v2_generated_CatalogService_RemoveCatalogAttribute_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\AttributesConfig;
use Google\Cloud\Retail\V2\CatalogServiceClient;

/**
 * Removes the specified
 * [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] from the
 * [AttributesConfig][google.cloud.retail.v2.AttributesConfig].
 *
 * If the [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to
 * remove does not exist, a NOT_FOUND error is returned.
 *
 * @param string $formattedAttributesConfig Full AttributesConfig resource name. Format:
 *                                          `projects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/attributesConfig`
 *                                          Please see {@see CatalogServiceClient::attributesConfigName()} for help formatting this field.
 * @param string $key                       The attribute name key of the
 *                                          [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to remove.
 */
function remove_catalog_attribute_sample(string $formattedAttributesConfig, string $key): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AttributesConfig $response */
        $response = $catalogServiceClient->removeCatalogAttribute($formattedAttributesConfig, $key);
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
    $formattedAttributesConfig = CatalogServiceClient::attributesConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]'
    );
    $key = '[KEY]';

    remove_catalog_attribute_sample($formattedAttributesConfig, $key);
}
// [END retail_v2_generated_CatalogService_RemoveCatalogAttribute_sync]
