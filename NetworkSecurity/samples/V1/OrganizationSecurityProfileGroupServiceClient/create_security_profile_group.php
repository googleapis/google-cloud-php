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

// [START networksecurity_v1_generated_OrganizationSecurityProfileGroupService_CreateSecurityProfileGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\OrganizationSecurityProfileGroupServiceClient;
use Google\Cloud\NetworkSecurity\V1\CreateSecurityProfileGroupRequest;
use Google\Cloud\NetworkSecurity\V1\SecurityProfileGroup;
use Google\Rpc\Status;

/**
 * Creates a new SecurityProfileGroup in a given organization and location.
 *
 * @param string $formattedParent        The parent resource of the SecurityProfileGroup. Must be in the
 *                                       format `projects|organizations/&#42;/locations/{location}`. Please see
 *                                       {@see OrganizationSecurityProfileGroupServiceClient::organizationLocationName()} for help formatting this field.
 * @param string $securityProfileGroupId Short name of the SecurityProfileGroup resource to be created.
 *                                       This value should be 1-63 characters long, containing only
 *                                       letters, numbers, hyphens, and underscores, and should not start
 *                                       with a number. E.g. "security_profile_group1".
 */
function create_security_profile_group_sample(
    string $formattedParent,
    string $securityProfileGroupId
): void {
    // Create a client.
    $organizationSecurityProfileGroupServiceClient = new OrganizationSecurityProfileGroupServiceClient();

    // Prepare the request message.
    $securityProfileGroup = new SecurityProfileGroup();
    $request = (new CreateSecurityProfileGroupRequest())
        ->setParent($formattedParent)
        ->setSecurityProfileGroupId($securityProfileGroupId)
        ->setSecurityProfileGroup($securityProfileGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $organizationSecurityProfileGroupServiceClient->createSecurityProfileGroup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SecurityProfileGroup $result */
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
    $formattedParent = OrganizationSecurityProfileGroupServiceClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );
    $securityProfileGroupId = '[SECURITY_PROFILE_GROUP_ID]';

    create_security_profile_group_sample($formattedParent, $securityProfileGroupId);
}
// [END networksecurity_v1_generated_OrganizationSecurityProfileGroupService_CreateSecurityProfileGroup_sync]
