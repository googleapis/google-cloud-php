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

// [START parametermanager_v1_generated_ParameterManager_CreateTemplateVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ParameterManager\V1\Client\ParameterManagerClient;
use Google\Cloud\ParameterManager\V1\CreateTemplateVersionRequest;
use Google\Cloud\ParameterManager\V1\TemplateVersion;
use Google\Cloud\ParameterManager\V1\TemplateVersionPayload;

/**
 * Creates a new TemplateVersion in a given project, location, and template.
 *
 * @param string $formattedParent            Value for parent in the format
 *                                           `projects/&#42;/locations/&#42;/templates/*`. Please see
 *                                           {@see ParameterManagerClient::templateName()} for help formatting this field.
 * @param string $templateVersionId          Id of the TemplateVersion resource
 * @param string $templateVersionPayloadData bytes data for storing payload.
 */
function create_template_version_sample(
    string $formattedParent,
    string $templateVersionId,
    string $templateVersionPayloadData
): void {
    // Create a client.
    $parameterManagerClient = new ParameterManagerClient();

    // Prepare the request message.
    $templateVersionPayload = (new TemplateVersionPayload())
        ->setData($templateVersionPayloadData);
    $templateVersion = (new TemplateVersion())
        ->setPayload($templateVersionPayload);
    $request = (new CreateTemplateVersionRequest())
        ->setParent($formattedParent)
        ->setTemplateVersionId($templateVersionId)
        ->setTemplateVersion($templateVersion);

    // Call the API and handle any network failures.
    try {
        /** @var TemplateVersion $response */
        $response = $parameterManagerClient->createTemplateVersion($request);
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
    $formattedParent = ParameterManagerClient::templateName('[PROJECT]', '[LOCATION]', '[TEMPLATE]');
    $templateVersionId = '[TEMPLATE_VERSION_ID]';
    $templateVersionPayloadData = '...';

    create_template_version_sample($formattedParent, $templateVersionId, $templateVersionPayloadData);
}
// [END parametermanager_v1_generated_ParameterManager_CreateTemplateVersion_sync]
