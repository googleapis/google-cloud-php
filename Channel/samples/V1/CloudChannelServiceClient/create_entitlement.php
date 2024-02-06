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

// [START cloudchannel_v1_generated_CloudChannelService_CreateEntitlement_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\CreateEntitlementRequest;
use Google\Cloud\Channel\V1\Entitlement;
use Google\Rpc\Status;

/**
 * Creates an entitlement for a customer.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED:
 * * The customer doesn't belong to the reseller.
 * * The reseller is not authorized to transact on this Product. See
 * https://support.google.com/channelservices/answer/9759265
 * * INVALID_ARGUMENT:
 * * Required request parameters are missing or invalid.
 * * There is already a customer entitlement for a SKU from the same
 * product family.
 * * INVALID_VALUE: Make sure the OfferId is valid. If it is, contact
 * Google Channel support for further troubleshooting.
 * * NOT_FOUND: The customer or offer resource was not found.
 * * ALREADY_EXISTS:
 * * The SKU was already purchased for the customer.
 * * The customer's primary email already exists. Retry
 * after changing the customer's primary contact email.
 * * CONDITION_NOT_MET or FAILED_PRECONDITION:
 * * The domain required for purchasing a SKU has not been verified.
 * * A pre-requisite SKU required to purchase an Add-On SKU is missing.
 * For example, Google Workspace Business Starter is required to purchase
 * Vault or Drive.
 * * (Developer accounts only) Reseller and resold domain must meet the
 * following naming requirements:
 * * Domain names must start with goog-test.
 * * Domain names must include the reseller domain.
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
 * @param string $formattedParent           The resource name of the reseller's customer account in which to
 *                                          create the entitlement. Parent uses the format:
 *                                          accounts/{account_id}/customers/{customer_id}
 *                                          Please see {@see CloudChannelServiceClient::customerName()} for help formatting this field.
 * @param string $formattedEntitlementOffer The offer resource name for which the entitlement is to be
 *                                          created. Takes the form: accounts/{account_id}/offers/{offer_id}. Please see
 *                                          {@see CloudChannelServiceClient::offerName()} for help formatting this field.
 */
function create_entitlement_sample(
    string $formattedParent,
    string $formattedEntitlementOffer
): void {
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $entitlement = (new Entitlement())
        ->setOffer($formattedEntitlementOffer);
    $request = (new CreateEntitlementRequest())
        ->setParent($formattedParent)
        ->setEntitlement($entitlement);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudChannelServiceClient->createEntitlement($request);
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
    $formattedParent = CloudChannelServiceClient::customerName('[ACCOUNT]', '[CUSTOMER]');
    $formattedEntitlementOffer = CloudChannelServiceClient::offerName('[ACCOUNT]', '[OFFER]');

    create_entitlement_sample($formattedParent, $formattedEntitlementOffer);
}
// [END cloudchannel_v1_generated_CloudChannelService_CreateEntitlement_sync]
