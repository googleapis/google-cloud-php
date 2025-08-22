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

// [START modelarmor_v1_generated_ModelArmor_CreateTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ModelArmor\V1\Client\ModelArmorClient;
use Google\Cloud\ModelArmor\V1\CreateTemplateRequest;
use Google\Cloud\ModelArmor\V1\FilterConfig;
use Google\Cloud\ModelArmor\V1\Template;

/**
 * Creates a new Template in a given project and location.
 *
 * @param string $formattedParent Value for parent. Please see
 *                                {@see ModelArmorClient::locationName()} for help formatting this field.
 * @param string $templateId      Id of the requesting object
 *                                If auto-generating Id server-side, remove this field and
 *                                template_id from the method_signature of Create RPC
 */
function create_template_sample(string $formattedParent, string $templateId): void
{
    // Create a client.
    $modelArmorClient = new ModelArmorClient();

    // Prepare the request message.
    $templateFilterConfig = new FilterConfig();
    $template = (new Template())
        ->setFilterConfig($templateFilterConfig);
    $request = (new CreateTemplateRequest())
        ->setParent($formattedParent)
        ->setTemplateId($templateId)
        ->setTemplate($template);

    // Call the API and handle any network failures.
    try {
        /** @var Template $response */
        $response = $modelArmorClient->createTemplate($request);
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
    $formattedParent = ModelArmorClient::locationName('[PROJECT]', '[LOCATION]');
    $templateId = '[TEMPLATE_ID]';

    create_template_sample($formattedParent, $templateId);
}
// [END modelarmor_v1_generated_ModelArmor_CreateTemplate_sync]
