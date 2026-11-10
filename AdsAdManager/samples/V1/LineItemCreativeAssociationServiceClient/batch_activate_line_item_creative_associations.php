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

// [START admanager_v1_generated_LineItemCreativeAssociationService_BatchActivateLineItemCreativeAssociations_sync]
use Google\Ads\AdManager\V1\BatchActivateLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\BatchActivateLineItemCreativeAssociationsResponse;
use Google\Ads\AdManager\V1\Client\LineItemCreativeAssociationServiceClient;
use Google\ApiCore\ApiException;

/**
 * Activate a list of `LineItemCreativeAssociation` objects.
 *
 * @param string $formattedParent       The parent resource where `LineItemCreativeAssociations` will be
 *                                      activated. This request supports using the "-" character as a wildcard for
 *                                      resources that span across multiple LineItem parents. Format:
 *                                      `networks/{network_code}/lineItems/{line_item_id}` Format:
 *                                      `networks/{network_code}/lineItems/-`
 *                                      Please see {@see LineItemCreativeAssociationServiceClient::lineItemName()} for help formatting this field.
 * @param string $formattedNamesElement The names of the `LineItemCreativeAssociation` objects to
 *                                      activate. A maximum of 1000 objects can be activated in a batch. Format:
 *                                      `networks/{network_code}/lineItems/{line_item_id}/creatives/{creative_id}`
 *                                      Please see {@see LineItemCreativeAssociationServiceClient::lineItemCreativeAssociationName()} for help formatting this field.
 */
function batch_activate_line_item_creative_associations_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $lineItemCreativeAssociationServiceClient = new LineItemCreativeAssociationServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement];
    $request = (new BatchActivateLineItemCreativeAssociationsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchActivateLineItemCreativeAssociationsResponse $response */
        $response = $lineItemCreativeAssociationServiceClient->batchActivateLineItemCreativeAssociations(
            $request
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
    $formattedParent = LineItemCreativeAssociationServiceClient::lineItemName(
        '[NETWORK_CODE]',
        '[LINE_ITEM]'
    );
    $formattedNamesElement = LineItemCreativeAssociationServiceClient::lineItemCreativeAssociationName(
        '[NETWORK_CODE]',
        '[LINE_ITEM]',
        '[CREATIVE]'
    );

    batch_activate_line_item_creative_associations_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_LineItemCreativeAssociationService_BatchActivateLineItemCreativeAssociations_sync]
