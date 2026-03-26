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

// [START networksecurity_v1_generated_OrganizationSecurityProfileGroupService_DeleteSecurityProfile_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\OrganizationSecurityProfileGroupServiceClient;
use Google\Cloud\NetworkSecurity\V1\DeleteSecurityProfileRequest;
use Google\Rpc\Status;

/**
 * Deletes a single SecurityProfile.
 *
 * @param string $formattedName A name of the SecurityProfile to delete. Must be in the format
 *                              `projects|organizations/&#42;/locations/{location}/securityProfiles/{security_profile_id}`. Please see
 *                              {@see OrganizationSecurityProfileGroupServiceClient::securityProfileName()} for help formatting this field.
 */
function delete_security_profile_sample(string $formattedName): void
{
    // Create a client.
    $organizationSecurityProfileGroupServiceClient = new OrganizationSecurityProfileGroupServiceClient();

    // Prepare the request message.
    $request = (new DeleteSecurityProfileRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $organizationSecurityProfileGroupServiceClient->deleteSecurityProfile($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = OrganizationSecurityProfileGroupServiceClient::securityProfileName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[SECURITY_PROFILE]'
    );

    delete_security_profile_sample($formattedName);
}
// [END networksecurity_v1_generated_OrganizationSecurityProfileGroupService_DeleteSecurityProfile_sync]
