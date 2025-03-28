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

// [START apihub_v1_generated_HostProjectRegistrationService_CreateHostProjectRegistration_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\HostProjectRegistrationServiceClient;
use Google\Cloud\ApiHub\V1\CreateHostProjectRegistrationRequest;
use Google\Cloud\ApiHub\V1\HostProjectRegistration;

/**
 * Create a host project registration.
 * A Google cloud project can be registered as a host project if it is not
 * attached as a runtime project to another host project.
 * A project can be registered as a host project only once. Subsequent
 * register calls for the same project will fail.
 *
 * @param string $formattedParent                            The parent resource for the host project.
 *                                                           Format: `projects/{project}/locations/{location}`
 *                                                           Please see {@see HostProjectRegistrationServiceClient::locationName()} for help formatting this field.
 * @param string $hostProjectRegistrationId                  The ID to use for the Host Project Registration, which will
 *                                                           become the final component of the host project registration's resource
 *                                                           name. The ID must be the same as the Google cloud project specified in the
 *                                                           host_project_registration.gcp_project field.
 * @param string $formattedHostProjectRegistrationGcpProject Immutable. Google cloud project name in the format:
 *                                                           "projects/abc" or "projects/123". As input, project name with either
 *                                                           project id or number are accepted. As output, this field will contain
 *                                                           project number. Please see
 *                                                           {@see HostProjectRegistrationServiceClient::projectName()} for help formatting this field.
 */
function create_host_project_registration_sample(
    string $formattedParent,
    string $hostProjectRegistrationId,
    string $formattedHostProjectRegistrationGcpProject
): void {
    // Create a client.
    $hostProjectRegistrationServiceClient = new HostProjectRegistrationServiceClient();

    // Prepare the request message.
    $hostProjectRegistration = (new HostProjectRegistration())
        ->setGcpProject($formattedHostProjectRegistrationGcpProject);
    $request = (new CreateHostProjectRegistrationRequest())
        ->setParent($formattedParent)
        ->setHostProjectRegistrationId($hostProjectRegistrationId)
        ->setHostProjectRegistration($hostProjectRegistration);

    // Call the API and handle any network failures.
    try {
        /** @var HostProjectRegistration $response */
        $response = $hostProjectRegistrationServiceClient->createHostProjectRegistration($request);
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
    $formattedParent = HostProjectRegistrationServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $hostProjectRegistrationId = '[HOST_PROJECT_REGISTRATION_ID]';
    $formattedHostProjectRegistrationGcpProject = HostProjectRegistrationServiceClient::projectName(
        '[PROJECT]'
    );

    create_host_project_registration_sample(
        $formattedParent,
        $hostProjectRegistrationId,
        $formattedHostProjectRegistrationGcpProject
    );
}
// [END apihub_v1_generated_HostProjectRegistrationService_CreateHostProjectRegistration_sync]
