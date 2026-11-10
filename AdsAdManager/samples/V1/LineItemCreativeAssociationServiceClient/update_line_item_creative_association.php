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

// [START admanager_v1_generated_LineItemCreativeAssociationService_UpdateLineItemCreativeAssociation_sync]
use Google\Ads\AdManager\V1\Client\LineItemCreativeAssociationServiceClient;
use Google\Ads\AdManager\V1\LineItemCreativeAssociation;
use Google\Ads\AdManager\V1\UpdateLineItemCreativeAssociationRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a `LineItemCreativeAssociation` object.
 *
 * @param string $formattedLineItemCreativeAssociationLineItem Immutable. The [LineItem][google.ads.admanager.v1.LineItem] to
 *                                                             which the LineItemCreativeAssociation belongs. Please see
 *                                                             {@see LineItemCreativeAssociationServiceClient::lineItemName()} for help formatting this field.
 */
function update_line_item_creative_association_sample(
    string $formattedLineItemCreativeAssociationLineItem
): void {
    // Create a client.
    $lineItemCreativeAssociationServiceClient = new LineItemCreativeAssociationServiceClient();

    // Prepare the request message.
    $lineItemCreativeAssociation = (new LineItemCreativeAssociation())
        ->setLineItem($formattedLineItemCreativeAssociationLineItem);
    $request = (new UpdateLineItemCreativeAssociationRequest())
        ->setLineItemCreativeAssociation($lineItemCreativeAssociation);

    // Call the API and handle any network failures.
    try {
        /** @var LineItemCreativeAssociation $response */
        $response = $lineItemCreativeAssociationServiceClient->updateLineItemCreativeAssociation($request);
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
    $formattedLineItemCreativeAssociationLineItem = LineItemCreativeAssociationServiceClient::lineItemName(
        '[NETWORK_CODE]',
        '[LINE_ITEM]'
    );

    update_line_item_creative_association_sample($formattedLineItemCreativeAssociationLineItem);
}
// [END admanager_v1_generated_LineItemCreativeAssociationService_UpdateLineItemCreativeAssociation_sync]
