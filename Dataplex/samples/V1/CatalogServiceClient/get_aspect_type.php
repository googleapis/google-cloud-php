<?php
/*
 * Copyright 2024 Google LLC
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

// [START dataplex_v1_generated_CatalogService_GetAspectType_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\AspectType;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\GetAspectTypeRequest;

/**
 * Retrieves a AspectType resource.
 *
 * @param string $formattedName The resource name of the AspectType:
 *                              `projects/{project_number}/locations/{location_id}/aspectTypes/{aspect_type_id}`. Please see
 *                              {@see CatalogServiceClient::aspectTypeName()} for help formatting this field.
 */
function get_aspect_type_sample(string $formattedName): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $request = (new GetAspectTypeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AspectType $response */
        $response = $catalogServiceClient->getAspectType($request);
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
    $formattedName = CatalogServiceClient::aspectTypeName('[PROJECT]', '[LOCATION]', '[ASPECT_TYPE]');

    get_aspect_type_sample($formattedName);
}
// [END dataplex_v1_generated_CatalogService_GetAspectType_sync]
