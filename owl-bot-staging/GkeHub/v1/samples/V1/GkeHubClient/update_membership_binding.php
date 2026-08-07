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

// [START gkehub_v1_generated_GkeHub_UpdateMembershipBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeHub\V1\Client\GkeHubClient;
use Google\Cloud\GkeHub\V1\MembershipBinding;
use Google\Cloud\GkeHub\V1\UpdateMembershipBindingRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a MembershipBinding.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_membership_binding_sample(): void
{
    // Create a client.
    $gkeHubClient = new GkeHubClient();

    // Prepare the request message.
    $membershipBinding = new MembershipBinding();
    $updateMask = new FieldMask();
    $request = (new UpdateMembershipBindingRequest())
        ->setMembershipBinding($membershipBinding)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gkeHubClient->updateMembershipBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MembershipBinding $result */
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
// [END gkehub_v1_generated_GkeHub_UpdateMembershipBinding_sync]
