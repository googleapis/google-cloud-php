<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudchannel_v1_generated_CloudChannelService_CancelEntitlement_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Rpc\Status;

/**
 * Cancels a previously fulfilled entitlement.
 *
 * An entitlement cancellation is a long-running operation.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request is different
 * from the reseller account in the API request.
 * * FAILED_PRECONDITION: There are Google Cloud projects linked to the
 * Google Cloud entitlement's Cloud Billing subaccount.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: Entitlement resource not found.
 * * DELETION_TYPE_NOT_ALLOWED: Cancel is only allowed for Google Workspace
 * add-ons, or entitlements for Google Cloud's development platform.
 * * INTERNAL: Any non-user error related to a technical issue in the
 * backend. Contact Cloud Channel support.
 * * UNKNOWN: Any non-user error related to a technical issue in the backend.
 * Contact Cloud Channel support.
 *
 * Return value:
 * The ID of a long-running operation.
 *
 * To get the results of the operation, call the GetOperation method of
 * CloudChannelOperationsService. The response will contain
 * google.protobuf.Empty on success. The Operation metadata will contain an
 * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
 *
 * @param string $name The resource name of the entitlement to cancel.
 *                     Name uses the format:
 *                     accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
 */
function cancel_entitlement_sample(string $name): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudChannelServiceClient->cancelEntitlement($name);
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
    $name = '[NAME]';

    cancel_entitlement_sample($name);
}
// [END cloudchannel_v1_generated_CloudChannelService_CancelEntitlement_sync]
