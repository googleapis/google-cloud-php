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

// [START apigeeregistry_v1_generated_Registry_ListApiDeploymentRevisions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ApigeeRegistry\V1\ApiDeployment;
use Google\Cloud\ApigeeRegistry\V1\Client\RegistryClient;
use Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentRevisionsRequest;

/**
 * Lists all revisions of a deployment.
 * Revisions are returned in descending order of revision creation time.
 *
 * @param string $formattedName The name of the deployment to list revisions for. Please see
 *                              {@see RegistryClient::apiDeploymentName()} for help formatting this field.
 */
function list_api_deployment_revisions_sample(string $formattedName): void
{
    // Create a client.
    $registryClient = new RegistryClient();

    // Prepare the request message.
    $request = (new ListApiDeploymentRevisionsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $registryClient->listApiDeploymentRevisions($request);

        /** @var ApiDeployment $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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

    list_api_deployment_revisions_sample($formattedName);
}
// [END apigeeregistry_v1_generated_Registry_ListApiDeploymentRevisions_sync]
