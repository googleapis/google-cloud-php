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

// [START designcenter_v1_generated_DesignCenter_CreateComponent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DesignCenter\V1\Client\DesignCenterClient;
use Google\Cloud\DesignCenter\V1\Component;
use Google\Cloud\DesignCenter\V1\CreateComponentRequest;

/**
 * Creates a component.
 *
 * @param string $formattedParent                    The parent resource in which to create the component. Please see
 *                                                   {@see DesignCenterClient::applicationTemplateName()} for help formatting this field.
 * @param string $componentId                        The ID of the component to create.
 * @param string $componentSharedTemplateRevisionUri Immutable. The shared template used to generate the component.
 */
function create_component_sample(
    string $formattedParent,
    string $componentId,
    string $componentSharedTemplateRevisionUri
): void {
    // Create a client.
    $designCenterClient = new DesignCenterClient();

    // Prepare the request message.
    $component = (new Component())
        ->setSharedTemplateRevisionUri($componentSharedTemplateRevisionUri);
    $request = (new CreateComponentRequest())
        ->setParent($formattedParent)
        ->setComponentId($componentId)
        ->setComponent($component);

    // Call the API and handle any network failures.
    try {
        /** @var Component $response */
        $response = $designCenterClient->createComponent($request);
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
    $formattedParent = DesignCenterClient::applicationTemplateName(
        '[PROJECT]',
        '[LOCATION]',
        '[SPACE]',
        '[APPLICATION_TEMPLATE]'
    );
    $componentId = '[COMPONENT_ID]';
    $componentSharedTemplateRevisionUri = '[SHARED_TEMPLATE_REVISION_URI]';

    create_component_sample($formattedParent, $componentId, $componentSharedTemplateRevisionUri);
}
// [END designcenter_v1_generated_DesignCenter_CreateComponent_sync]
