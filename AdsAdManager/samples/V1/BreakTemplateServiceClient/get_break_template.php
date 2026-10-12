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

// [START admanager_v1_generated_BreakTemplateService_GetBreakTemplate_sync]
use Google\Ads\AdManager\V1\BreakTemplate;
use Google\Ads\AdManager\V1\Client\BreakTemplateServiceClient;
use Google\Ads\AdManager\V1\GetBreakTemplateRequest;
use Google\ApiCore\ApiException;

/**
 * Retrieves a `BreakTemplate` object.
 *
 * @param string $formattedName The resource name of the `BreakTemplate`.
 *                              Format: `networks/{network_code}/breakTemplates/{break_template_id}`
 *                              Please see {@see BreakTemplateServiceClient::breakTemplateName()} for help formatting this field.
 */
function get_break_template_sample(string $formattedName): void
{
    // Create a client.
    $breakTemplateServiceClient = new BreakTemplateServiceClient();

    // Prepare the request message.
    $request = (new GetBreakTemplateRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var BreakTemplate $response */
        $response = $breakTemplateServiceClient->getBreakTemplate($request);
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
    $formattedName = BreakTemplateServiceClient::breakTemplateName(
        '[NETWORK_CODE]',
        '[BREAK_TEMPLATE]'
    );

    get_break_template_sample($formattedName);
}
// [END admanager_v1_generated_BreakTemplateService_GetBreakTemplate_sync]
