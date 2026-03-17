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

// [START dataplex_v1_generated_CatalogService_LookupContext_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\LookupContextRequest;
use Google\Cloud\Dataplex\V1\LookupContextResponse;

/**
 * Looks up LLM Context for the specified resources.
 *
 * @param string $name                      The project to which the request should be attributed in the
 *                                          following form: `projects/{project}/locations/{location}`.
 * @param string $formattedResourcesElement The entry names to lookup context for. The request should have
 *                                          max 10 of those.
 *
 *                                          ## Examples:
 *
 *                                          projects/{project}/locations/{location}/entryGroups/{entry_group}/entries/{entry}
 *                                          Please see {@see CatalogServiceClient::entryName()} for help formatting this field.
 */
function lookup_context_sample(string $name, string $formattedResourcesElement): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $formattedResources = [$formattedResourcesElement,];
    $request = (new LookupContextRequest())
        ->setName($name)
        ->setResources($formattedResources);

    // Call the API and handle any network failures.
    try {
        /** @var LookupContextResponse $response */
        $response = $catalogServiceClient->lookupContext($request);
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
    $name = '[NAME]';
    $formattedResourcesElement = CatalogServiceClient::entryName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENTRY_GROUP]',
        '[ENTRY]'
    );

    lookup_context_sample($name, $formattedResourcesElement);
}
// [END dataplex_v1_generated_CatalogService_LookupContext_sync]
