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

// [START iam_v2_generated_Policies_UpdatePolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Iam\V2\Client\PoliciesClient;
use Google\Cloud\Iam\V2\Policy;
use Google\Cloud\Iam\V2\UpdatePolicyRequest;
use Google\Rpc\Status;

/**
 * Updates the specified policy.
 *
 * You can update only the rules and the display name for the policy.
 *
 * To update a policy, you should use a read-modify-write loop:
 *
 * 1. Use [GetPolicy][google.iam.v2.Policies.GetPolicy] to read the current version of the policy.
 * 2. Modify the policy as needed.
 * 3. Use `UpdatePolicy` to write the updated policy.
 *
 * This pattern helps prevent conflicts between concurrent updates.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_policy_sample(): void
{
    // Create a client.
    $policiesClient = new PoliciesClient();

    // Prepare the request message.
    $policy = new Policy();
    $request = (new UpdatePolicyRequest())
        ->setPolicy($policy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $policiesClient->updatePolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Policy $result */
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
// [END iam_v2_generated_Policies_UpdatePolicy_sync]
