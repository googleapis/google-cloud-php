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

// [START retail_v2_generated_CatalogService_ReplaceCatalogAttribute_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\AttributesConfig;
use Google\Cloud\Retail\V2\CatalogAttribute;
use Google\Cloud\Retail\V2\CatalogServiceClient;

/**
 * Replaces the specified
 * [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] in the
 * [AttributesConfig][google.cloud.retail.v2.AttributesConfig] by updating the
 * catalog attribute with the same
 * [CatalogAttribute.key][google.cloud.retail.v2.CatalogAttribute.key].
 *
 * If the [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to
 * replace does not exist, a NOT_FOUND error is returned.
 *
 * @param string $formattedAttributesConfig Full AttributesConfig resource name. Format:
 *                                          `projects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/attributesConfig`
 *                                          Please see {@see CatalogServiceClient::attributesConfigName()} for help formatting this field.
 * @param string $catalogAttributeKey       Attribute name.
 *                                          For example: `color`, `brands`, `attributes.custom_attribute`, such as
 *                                          `attributes.xyz`.
 *                                          To be indexable, the attribute name can contain only alpha-numeric
 *                                          characters and underscores. For example, an attribute named
 *                                          `attributes.abc_xyz` can be indexed, but an attribute named
 *                                          `attributes.abc-xyz` cannot be indexed.
 */
function replace_catalog_attribute_sample(
    string $formattedAttributesConfig,
    string $catalogAttributeKey
): void {
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $catalogAttribute = (new CatalogAttribute())
        ->setKey($catalogAttributeKey);

    // Call the API and handle any network failures.
    try {
        /** @var AttributesConfig $response */
        $response = $catalogServiceClient->replaceCatalogAttribute(
            $formattedAttributesConfig,
            $catalogAttribute
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
    $formattedAttributesConfig = CatalogServiceClient::attributesConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]'
    );
    $catalogAttributeKey = '[KEY]';

    replace_catalog_attribute_sample($formattedAttributesConfig, $catalogAttributeKey);
}
// [END retail_v2_generated_CatalogService_ReplaceCatalogAttribute_sync]
