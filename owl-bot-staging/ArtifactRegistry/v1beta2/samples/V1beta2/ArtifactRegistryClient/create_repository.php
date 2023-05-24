<?php
/*
 * Copyright 2023 Google LLC
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

// [START artifactregistry_v1beta2_generated_ArtifactRegistry_CreateRepository_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ArtifactRegistry\V1beta2\ArtifactRegistryClient;
use Google\Cloud\ArtifactRegistry\V1beta2\Repository;
use Google\Rpc\Status;

/**
 * Creates a repository. The returned Operation will finish once the
 * repository has been created. Its response will be the created Repository.
 *
 * @param string $formattedParent The name of the parent resource where the repository will be created. Please see
 *                                {@see ArtifactRegistryClient::locationName()} for help formatting this field.
 */
function create_repository_sample(string $formattedParent): void
{
    // Create a client.
    $artifactRegistryClient = new ArtifactRegistryClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $artifactRegistryClient->createRepository($formattedParent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Repository $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = ArtifactRegistryClient::locationName('[PROJECT]', '[LOCATION]');

    create_repository_sample($formattedParent);
}
// [END artifactregistry_v1beta2_generated_ArtifactRegistry_CreateRepository_sync]
