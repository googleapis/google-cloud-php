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

// [START cloudchannel_v1_generated_CloudChannelService_TransferEntitlements_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Channel\V1\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\Entitlement;
use Google\Cloud\Channel\V1\TransferEntitlementsResponse;
use Google\Rpc\Status;

/**
 * Transfers customer entitlements to new reseller.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: The customer or offer resource was not found.
 * * ALREADY_EXISTS: The SKU was already transferred for the customer.
 * * CONDITION_NOT_MET or FAILED_PRECONDITION:
 * * The SKU requires domain verification to transfer, but the domain is
 * not verified.
 * * An Add-On SKU (example, Vault or Drive) is missing the
 * pre-requisite SKU (example, G Suite Basic).
 * * (Developer accounts only) Reseller and resold domain must meet the
 * following naming requirements:
 * * Domain names must start with goog-test.
 * * Domain names must include the reseller domain.
 * * Specify all transferring entitlements.
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
 * @param string $parent                     The resource name of the reseller's customer account that will
 *                                           receive transferred entitlements. Parent uses the format:
 *                                           accounts/{account_id}/customers/{customer_id}
 * @param string $formattedEntitlementsOffer The offer resource name for which the entitlement is to be
 *                                           created. Takes the form: accounts/{account_id}/offers/{offer_id}. Please see
 *                                           {@see CloudChannelServiceClient::offerName()} for help formatting this field.
 */
function transfer_entitlements_sample(string $parent, string $formattedEntitlementsOffer): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $entitlement = (new Entitlement())
        ->setOffer($formattedEntitlementsOffer);
    $entitlements = [$entitlement,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudChannelServiceClient->transferEntitlements($parent, $entitlements);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TransferEntitlementsResponse $result */
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
    $parent = '[PARENT]';
    $formattedEntitlementsOffer = CloudChannelServiceClient::offerName('[ACCOUNT]', '[OFFER]');

    transfer_entitlements_sample($parent, $formattedEntitlementsOffer);
}
// [END cloudchannel_v1_generated_CloudChannelService_TransferEntitlements_sync]
