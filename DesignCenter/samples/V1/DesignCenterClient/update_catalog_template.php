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

// [START designcenter_v1_generated_DesignCenter_UpdateCatalogTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DesignCenter\V1\CatalogTemplate;
use Google\Cloud\DesignCenter\V1\Client\DesignCenterClient;
use Google\Cloud\DesignCenter\V1\TemplateCategory;
use Google\Cloud\DesignCenter\V1\UpdateCatalogTemplateRequest;

/**
 * Updates a catalog template resource.
 *
 * @param int $catalogTemplateTemplateCategory The category of the Application Design Center application
 *                                             template.
 */
function update_catalog_template_sample(int $catalogTemplateTemplateCategory): void
{
    // Create a client.
    $designCenterClient = new DesignCenterClient();

    // Prepare the request message.
    $catalogTemplate = (new CatalogTemplate())
        ->setTemplateCategory($catalogTemplateTemplateCategory);
    $request = (new UpdateCatalogTemplateRequest())
        ->setCatalogTemplate($catalogTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var CatalogTemplate $response */
        $response = $designCenterClient->updateCatalogTemplate($request);
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
    $catalogTemplateTemplateCategory = TemplateCategory::TEMPLATE_CATEGORY_UNSPECIFIED;

    update_catalog_template_sample($catalogTemplateTemplateCategory);
}
// [END designcenter_v1_generated_DesignCenter_UpdateCatalogTemplate_sync]
