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

// [START commerceproducer_v1beta_generated_CommerceTransaction_ResolveAmendmentTarget_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Commerceproducer\V1beta\Client\CommerceTransactionClient;
use Google\Cloud\Commerceproducer\V1beta\ResolveAmendmentTargetRequest;
use Google\Cloud\Commerceproducer\V1beta\ResolveAmendmentTargetResponse;

/**
 * Resolves the existing offer that must be amended when creating a new
 * PrivateOffer. Use this method to determine the correct amendment target
 * before creating or publishing an offer.
 *
 * @param string $formattedParent               Parent value for ResolveAmendmentTargetRequest
 *                                              Please see {@see CommerceTransactionClient::locationName()} for help formatting this field.
 * @param string $formattedTargetBillingAccount The customer's billing account targeted by the offer. This is the
 *                                              billing account for which the new private offer will be created on. Format:
 *                                              billingAccounts/{billing_account}. Please see
 *                                              {@see CommerceTransactionClient::billingAccountName()} for help formatting this field.
 * @param string $formattedBaseStandardOffer    The base standard offer that the private offer will be based on.
 *                                              Format:
 *                                              projects/{project}/locations/{location}/services/{service}/standardOffers/{standard_offer}. Please see
 *                                              {@see CommerceTransactionClient::standardOfferName()} for help formatting this field.
 */
function resolve_amendment_target_sample(
    string $formattedParent,
    string $formattedTargetBillingAccount,
    string $formattedBaseStandardOffer
): void {
    // Create a client.
    $commerceTransactionClient = new CommerceTransactionClient();

    // Prepare the request message.
    $request = (new ResolveAmendmentTargetRequest())
        ->setParent($formattedParent)
        ->setTargetBillingAccount($formattedTargetBillingAccount)
        ->setBaseStandardOffer($formattedBaseStandardOffer);

    // Call the API and handle any network failures.
    try {
        /** @var ResolveAmendmentTargetResponse $response */
        $response = $commerceTransactionClient->resolveAmendmentTarget($request);
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
    $formattedParent = CommerceTransactionClient::locationName('[PROJECT]', '[LOCATION]');
    $formattedTargetBillingAccount = CommerceTransactionClient::billingAccountName('[BILLING_ACCOUNT]');
    $formattedBaseStandardOffer = CommerceTransactionClient::standardOfferName(
        '[PROJECT]',
        '[LOCATION]',
        '[SERVICE]',
        '[STANDARD_OFFER]'
    );

    resolve_amendment_target_sample(
        $formattedParent,
        $formattedTargetBillingAccount,
        $formattedBaseStandardOffer
    );
}
// [END commerceproducer_v1beta_generated_CommerceTransaction_ResolveAmendmentTarget_sync]
