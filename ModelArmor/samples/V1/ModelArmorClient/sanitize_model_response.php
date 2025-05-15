<?php
/*
 * Copyright 2025 Google LLC
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

// [START modelarmor_v1_generated_ModelArmor_SanitizeModelResponse_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ModelArmor\V1\Client\ModelArmorClient;
use Google\Cloud\ModelArmor\V1\DataItem;
use Google\Cloud\ModelArmor\V1\SanitizeModelResponseRequest;
use Google\Cloud\ModelArmor\V1\SanitizeModelResponseResponse;

/**
 * Sanitizes Model Response.
 *
 * @param string $formattedName Represents resource name of template
 *                              e.g. name=projects/sample-project/locations/us-central1/templates/templ01
 *                              Please see {@see ModelArmorClient::templateName()} for help formatting this field.
 */
function sanitize_model_response_sample(string $formattedName): void
{
    // Create a client.
    $modelArmorClient = new ModelArmorClient();

    // Prepare the request message.
    $modelResponseData = new DataItem();
    $request = (new SanitizeModelResponseRequest())
        ->setName($formattedName)
        ->setModelResponseData($modelResponseData);

    // Call the API and handle any network failures.
    try {
        /** @var SanitizeModelResponseResponse $response */
        $response = $modelArmorClient->sanitizeModelResponse($request);
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
    $formattedName = ModelArmorClient::templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');

    sanitize_model_response_sample($formattedName);
}
// [END modelarmor_v1_generated_ModelArmor_SanitizeModelResponse_sync]
