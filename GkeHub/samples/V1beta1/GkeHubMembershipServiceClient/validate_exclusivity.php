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

// [START gkehub_v1beta1_generated_GkeHubMembershipService_ValidateExclusivity_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeHub\V1beta1\GkeHubMembershipServiceClient;
use Google\Cloud\GkeHub\V1beta1\ValidateExclusivityResponse;

/**
 * ValidateExclusivity validates the state of exclusivity in the cluster.
 * The validation does not depend on an existing Hub membership resource.
 *
 * @param string $formattedParent    The parent (project and location) where the Memberships will be created.
 *                                   Specified in the format `projects/&#42;/locations/*`. Please see
 *                                   {@see GkeHubMembershipServiceClient::locationName()} for help formatting this field.
 * @param string $intendedMembership The intended membership name under the `parent`. This method only does
 *                                   validation in anticipation of a CreateMembership call with the same name.
 */
function validate_exclusivity_sample(string $formattedParent, string $intendedMembership): void
{
    // Create a client.
    $gkeHubMembershipServiceClient = new GkeHubMembershipServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ValidateExclusivityResponse $response */
        $response = $gkeHubMembershipServiceClient->validateExclusivity(
            $formattedParent,
            $intendedMembership
        );
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
    $formattedParent = GkeHubMembershipServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $intendedMembership = '[INTENDED_MEMBERSHIP]';

    validate_exclusivity_sample($formattedParent, $intendedMembership);
}
// [END gkehub_v1beta1_generated_GkeHubMembershipService_ValidateExclusivity_sync]
