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

// [START cloudchannel_v1_generated_CloudChannelService_ActivateEntitlement_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Channel\V1\ActivateEntitlementRequest;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Entitlement;
use Google\Rpc\Status;

/**
 * Activates a previously suspended entitlement. Entitlements suspended for
 * pending ToS acceptance can't be activated using this method.
 *
 * An entitlement activation is a long-running operation and it updates
 * the state of the customer entitlement.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request is different
 * from the reseller account in the API request.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: Entitlement resource not found.
 * * SUSPENSION_NOT_RESELLER_INITIATED: Can only activate reseller-initiated
 * suspensions and entitlements that have accepted the TOS.
 * * NOT_SUSPENDED: Can only activate suspended entitlements not in an ACTIVE
 * state.
 * * INTERNAL: Any non-user error related to a technical issue in the
 * backend. Contact Cloud Channel support.
 * * UNKNOWN: Any non-user error related to a technical issue in the backend.
 * Contact Cloud Channel support.
 *
 * Return value:
 * The ID of a long-running operation.
 *
 * To get the results of the operation, call the GetOperation method of
 * CloudChannelOperationsService. The Operation metadata will contain an
 * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
 *
 * @param string $name The resource name of the entitlement to activate.
 *                     Name uses the format:
 *                     accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
 */
function activate_entitlement_sample(string $name): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new ActivateEntitlementRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudChannelServiceClient->activateEntitlement($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Entitlement $result */
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
    $name = '[NAME]';

    activate_entitlement_sample($name);
}
// [END cloudchannel_v1_generated_CloudChannelService_ActivateEntitlement_sync]
