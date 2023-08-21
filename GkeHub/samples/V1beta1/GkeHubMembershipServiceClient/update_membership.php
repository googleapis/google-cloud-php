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

// [START gkehub_v1beta1_generated_GkeHubMembershipService_UpdateMembership_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeHub\V1beta1\GkeHubMembershipServiceClient;
use Google\Cloud\GkeHub\V1beta1\Membership;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an existing Membership.
 *
 * @param string $formattedName The membership resource name in the format:
 *                              `projects/[project_id]/locations/global/memberships/[membership_id]`
 *                              Please see {@see GkeHubMembershipServiceClient::membershipName()} for help formatting this field.
 */
function update_membership_sample(string $formattedName): void
{
    // Create a client.
    $gkeHubMembershipServiceClient = new GkeHubMembershipServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $updateMask = new FieldMask();
    $resource = new Membership();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gkeHubMembershipServiceClient->updateMembership(
            $formattedName,
            $updateMask,
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
    $formattedName = GkeHubMembershipServiceClient::membershipName(
        '[PROJECT]',
        '[LOCATION]',
        '[MEMBERSHIP]'
    );

    update_membership_sample($formattedName);
}
// [END gkehub_v1beta1_generated_GkeHubMembershipService_UpdateMembership_sync]
