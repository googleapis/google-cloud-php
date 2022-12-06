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

// [START retail_v2_generated_CatalogService_UpdateAttributesConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\AttributesConfig;
use Google\Cloud\Retail\V2\CatalogServiceClient;

/**
 * Updates the [AttributesConfig][google.cloud.retail.v2.AttributesConfig].
 *
 * The catalog attributes in the request will be updated in the catalog, or
 * inserted if they do not exist. Existing catalog attributes not included in
 * the request will remain unchanged. Attributes that are assigned to
 * products, but do not exist at the catalog level, are always included in the
 * response. The product attribute is assigned default values for missing
 * catalog attribute fields, e.g., searchable and dynamic facetable options.
 *
 * @param string $attributesConfigName Immutable. The fully qualified resource name of the attribute
 *                                     config. Format: `projects/&#42;/locations/&#42;/catalogs/&#42;/attributesConfig`
 */
function update_attributes_config_sample(string $attributesConfigName): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $attributesConfig = (new AttributesConfig())
        ->setName($attributesConfigName);

    // Call the API and handle any network failures.
    try {
        /** @var AttributesConfig $response */
        $response = $catalogServiceClient->updateAttributesConfig($attributesConfig);
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
    $attributesConfigName = '[NAME]';

    update_attributes_config_sample($attributesConfigName);
}
// [END retail_v2_generated_CatalogService_UpdateAttributesConfig_sync]
