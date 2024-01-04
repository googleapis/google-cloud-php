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

// [START osconfig_v1_generated_OsConfigService_CreatePatchDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OsConfig\V1\Client\OsConfigServiceClient;
use Google\Cloud\OsConfig\V1\CreatePatchDeploymentRequest;
use Google\Cloud\OsConfig\V1\OneTimeSchedule;
use Google\Cloud\OsConfig\V1\PatchDeployment;
use Google\Cloud\OsConfig\V1\PatchInstanceFilter;
use Google\Protobuf\Timestamp;

/**
 * Create an OS Config patch deployment.
 *
 * @param string $formattedParent   The project to apply this patch deployment to in the form
 *                                  `projects/*`. Please see
 *                                  {@see OsConfigServiceClient::projectName()} for help formatting this field.
 * @param string $patchDeploymentId A name for the patch deployment in the project. When creating a
 *                                  name the following rules apply:
 *                                  * Must contain only lowercase letters, numbers, and hyphens.
 *                                  * Must start with a letter.
 *                                  * Must be between 1-63 characters.
 *                                  * Must end with a number or a letter.
 *                                  * Must be unique within the project.
 */
function create_patch_deployment_sample(string $formattedParent, string $patchDeploymentId): void
{
    // Create a client.
    $osConfigServiceClient = new OsConfigServiceClient();

    // Prepare the request message.
    $patchDeploymentInstanceFilter = new PatchInstanceFilter();
    $patchDeploymentOneTimeScheduleExecuteTime = new Timestamp();
    $patchDeploymentOneTimeSchedule = (new OneTimeSchedule())
        ->setExecuteTime($patchDeploymentOneTimeScheduleExecuteTime);
    $patchDeployment = (new PatchDeployment())
        ->setInstanceFilter($patchDeploymentInstanceFilter)
        ->setOneTimeSchedule($patchDeploymentOneTimeSchedule);
    $request = (new CreatePatchDeploymentRequest())
        ->setParent($formattedParent)
        ->setPatchDeploymentId($patchDeploymentId)
        ->setPatchDeployment($patchDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var PatchDeployment $response */
        $response = $osConfigServiceClient->createPatchDeployment($request);
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
    $formattedParent = OsConfigServiceClient::projectName('[PROJECT]');
    $patchDeploymentId = '[PATCH_DEPLOYMENT_ID]';

    create_patch_deployment_sample($formattedParent, $patchDeploymentId);
}
// [END osconfig_v1_generated_OsConfigService_CreatePatchDeployment_sync]
