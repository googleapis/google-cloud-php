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

// [START apigeeregistry_v1_generated_Registry_TagApiDeploymentRevision_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApigeeRegistry\V1\ApiDeployment;
use Google\Cloud\ApigeeRegistry\V1\RegistryClient;

/**
 * Adds a tag to a specified revision of a
 * deployment.
 *
 * @param string $formattedName The name of the deployment to be tagged, including the revision ID. Please see
 *                              {@see RegistryClient::apiDeploymentName()} for help formatting this field.
 * @param string $tag           The tag to apply.
 *                              The tag should be at most 40 characters, and match `[a-z][a-z0-9-]{3,39}`.
 */
function tag_api_deployment_revision_sample(string $formattedName, string $tag): void
{
    // Create a client.
    $registryClient = new RegistryClient();

    // Call the API and handle any network failures.
    try {
        /** @var ApiDeployment $response */
        $response = $registryClient->tagApiDeploymentRevision($formattedName, $tag);
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
    $formattedName = RegistryClient::apiDeploymentName(
        '[PROJECT]',
        '[LOCATION]',
        '[API]',
        '[DEPLOYMENT]'
    );
    $tag = '[TAG]';

    tag_api_deployment_revision_sample($formattedName, $tag);
}
// [END apigeeregistry_v1_generated_Registry_TagApiDeploymentRevision_sync]
