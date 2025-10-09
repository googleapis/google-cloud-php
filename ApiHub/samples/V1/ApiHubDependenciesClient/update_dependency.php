<?php
/*
 * Copyright 2024 Google LLC
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

// [START apihub_v1_generated_ApiHubDependencies_UpdateDependency_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\ApiHubDependenciesClient;
use Google\Cloud\ApiHub\V1\Dependency;
use Google\Cloud\ApiHub\V1\DependencyEntityReference;
use Google\Cloud\ApiHub\V1\UpdateDependencyRequest;
use Google\Protobuf\FieldMask;

/**
 * Update a dependency based on the
 * [update_mask][google.cloud.apihub.v1.UpdateDependencyRequest.update_mask]
 * provided in the request.
 *
 * The following fields in the [dependency][google.cloud.apihub.v1.Dependency]
 * can be updated:
 * * [description][google.cloud.apihub.v1.Dependency.description]
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_dependency_sample(): void
{
    // Create a client.
    $apiHubDependenciesClient = new ApiHubDependenciesClient();

    // Prepare the request message.
    $dependencyConsumer = new DependencyEntityReference();
    $dependencySupplier = new DependencyEntityReference();
    $dependency = (new Dependency())
        ->setConsumer($dependencyConsumer)
        ->setSupplier($dependencySupplier);
    $updateMask = new FieldMask();
    $request = (new UpdateDependencyRequest())
        ->setDependency($dependency)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Dependency $response */
        $response = $apiHubDependenciesClient->updateDependency($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END apihub_v1_generated_ApiHubDependencies_UpdateDependency_sync]
