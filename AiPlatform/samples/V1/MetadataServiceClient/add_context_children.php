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

// [START aiplatform_v1_generated_MetadataService_AddContextChildren_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\AddContextChildrenRequest;
use Google\Cloud\AIPlatform\V1\AddContextChildrenResponse;
use Google\Cloud\AIPlatform\V1\Client\MetadataServiceClient;

/**
 * Adds a set of Contexts as children to a parent Context. If any of the
 * child Contexts have already been added to the parent Context, they are
 * simply skipped. If this call would create a cycle or cause any Context to
 * have more than 10 parents, the request will fail with an INVALID_ARGUMENT
 * error.
 *
 * @param string $formattedContext The resource name of the parent Context.
 *
 *                                 Format:
 *                                 `projects/{project}/locations/{location}/metadataStores/{metadatastore}/contexts/{context}`
 *                                 Please see {@see MetadataServiceClient::contextName()} for help formatting this field.
 */
function add_context_children_sample(string $formattedContext): void
{
    // Create a client.
    $metadataServiceClient = new MetadataServiceClient();

    // Prepare the request message.
    $request = (new AddContextChildrenRequest())
        ->setContext($formattedContext);

    // Call the API and handle any network failures.
    try {
        /** @var AddContextChildrenResponse $response */
        $response = $metadataServiceClient->addContextChildren($request);
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
    $formattedContext = MetadataServiceClient::contextName(
        '[PROJECT]',
        '[LOCATION]',
        '[METADATA_STORE]',
        '[CONTEXT]'
    );

    add_context_children_sample($formattedContext);
}
// [END aiplatform_v1_generated_MetadataService_AddContextChildren_sync]
