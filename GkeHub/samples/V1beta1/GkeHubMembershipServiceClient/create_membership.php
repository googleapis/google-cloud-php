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

// [START gkehub_v1beta1_generated_GkeHubMembershipService_CreateMembership_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeHub\V1beta1\GkeHubMembershipServiceClient;
use Google\Cloud\GkeHub\V1beta1\Membership;
use Google\Rpc\Status;

/**
 * Creates a new Membership.
 *
 * **This is currently only supported for GKE clusters on Google Cloud**.
 * To register other clusters, follow the instructions at
 * https://cloud.google.com/anthos/multicluster-management/connect/registering-a-cluster.
 *
 * @param string $formattedParent The parent (project and location) where the Memberships will be created.
 *                                Specified in the format `projects/&#42;/locations/*`. Please see
 *                                {@see GkeHubMembershipServiceClient::locationName()} for help formatting this field.
 * @param string $membershipId    Client chosen ID for the membership. `membership_id` must be a valid RFC
 *                                1123 compliant DNS label:
 *
 *                                1. At most 63 characters in length
 *                                2. It must consist of lower case alphanumeric characters or `-`
 *                                3. It must start and end with an alphanumeric character
 *
 *                                Which can be expressed as the regex: `[a-z0-9]([-a-z0-9]*[a-z0-9])?`,
 *                                with a maximum length of 63 characters.
 */
function create_membership_sample(string $formattedParent, string $membershipId): void
{
    // Create a client.
    $gkeHubMembershipServiceClient = new GkeHubMembershipServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $resource = new Membership();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gkeHubMembershipServiceClient->createMembership(
            $formattedParent,
            $membershipId,
            $resource
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Membership $result */
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
    $formattedParent = GkeHubMembershipServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $membershipId = '[MEMBERSHIP_ID]';

    create_membership_sample($formattedParent, $membershipId);
}
// [END gkehub_v1beta1_generated_GkeHubMembershipService_CreateMembership_sync]
