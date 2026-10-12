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

// [START auditmanager_v1_generated_AuditManager_EnrollResource_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AuditManager\V1\Client\AuditManagerClient;
use Google\Cloud\AuditManager\V1\EnrollResourceRequest;
use Google\Cloud\AuditManager\V1\EnrollResourceRequest\EligibleDestination;
use Google\Cloud\AuditManager\V1\Enrollment;

/**
 * Adds your project, folder, or organization to Audit
 * Manager. This method creates the Audit Manager service agent in your
 * workload and grants required permissions to the service agent.
 * If you make this request on a workload that's already enrolled,
 * then this method overrides the existing set of destinations.
 *
 * @param string $scope Organization, folder, or project to enroll in Audit Manager, in
 *                      one of the following formats:
 *
 *                      * `projects/{project}/locations/{location}`
 *                      * `folders/{folder}/locations/{location}`
 *                      * `organizations/{organization}/locations/{location}`
 */
function enroll_resource_sample(string $scope): void
{
    // Create a client.
    $auditManagerClient = new AuditManagerClient();

    // Prepare the request message.
    $destinations = [new EligibleDestination()];
    $request = (new EnrollResourceRequest())
        ->setScope($scope)
        ->setDestinations($destinations);

    // Call the API and handle any network failures.
    try {
        /** @var Enrollment $response */
        $response = $auditManagerClient->enrollResource($request);
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
    $scope = '[SCOPE]';

    enroll_resource_sample($scope);
}
// [END auditmanager_v1_generated_AuditManager_EnrollResource_sync]
