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

// [START admanager_v1_generated_LineItemService_UpdateLineItem_sync]
use Google\Ads\AdManager\V1\Client\LineItemServiceClient;
use Google\Ads\AdManager\V1\CreativePlaceholder;
use Google\Ads\AdManager\V1\CreativeRotationTypeEnum\CreativeRotationType;
use Google\Ads\AdManager\V1\LineItem;
use Google\Ads\AdManager\V1\LineItemCostTypeEnum\LineItemCostType;
use Google\Ads\AdManager\V1\LineItemTypeEnum\LineItemType;
use Google\Ads\AdManager\V1\Size;
use Google\Ads\AdManager\V1\SizeTypeEnum\SizeType;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\UpdateLineItemRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\Timestamp;
use Google\Type\Money;

/**
 * Updates a `LineItem` object.
 *
 * @param string $formattedLineItemOrder                   Immutable. The ID of the Order to which the LineItem belongs.
 *                                                         Format: `networks/{network_code}/orders/{order}`
 *                                                         Please see {@see LineItemServiceClient::orderName()} for help formatting this field.
 * @param string $lineItemDisplayName                      The name of the line item. This attribute has a maximum length of
 *                                                         255 characters.
 * @param int    $lineItemCreativeRotationType             The strategy used for displaying multiple Creative objects that
 *                                                         are associated with the LineItem.
 * @param int    $lineItemLineItemType                     Indicates the line item type of a LineItem. The line item type
 *                                                         determines the default priority of the line item. More information can be
 *                                                         found at https://support.google.com/admanager/answer/177279.
 * @param int    $lineItemCostType                         The method used for billing this LineItem.
 * @param int    $lineItemCreativePlaceholdersSizeWidth    The width of the Creative,
 *                                                         [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $lineItemCreativePlaceholdersSizeHeight   The height of the Creative,
 *                                                         [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $lineItemCreativePlaceholdersSizeSizeType The SizeType of the Creative,
 *                                                         [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 */
function update_line_item_sample(
    string $formattedLineItemOrder,
    string $lineItemDisplayName,
    int $lineItemCreativeRotationType,
    int $lineItemLineItemType,
    int $lineItemCostType,
    int $lineItemCreativePlaceholdersSizeWidth,
    int $lineItemCreativePlaceholdersSizeHeight,
    int $lineItemCreativePlaceholdersSizeSizeType
): void {
    // Create a client.
    $lineItemServiceClient = new LineItemServiceClient();

    // Prepare the request message.
    $lineItemStartTime = new Timestamp();
    $lineItemRate = new Money();
    $lineItemCreativePlaceholdersSize = (new Size())
        ->setWidth($lineItemCreativePlaceholdersSizeWidth)
        ->setHeight($lineItemCreativePlaceholdersSizeHeight)
        ->setSizeType($lineItemCreativePlaceholdersSizeSizeType);
    $creativePlaceholder = (new CreativePlaceholder())
        ->setSize($lineItemCreativePlaceholdersSize);
    $lineItemCreativePlaceholders = [$creativePlaceholder,];
    $lineItemTargeting = new Targeting();
    $lineItem = (new LineItem())
        ->setOrder($formattedLineItemOrder)
        ->setDisplayName($lineItemDisplayName)
        ->setStartTime($lineItemStartTime)
        ->setCreativeRotationType($lineItemCreativeRotationType)
        ->setLineItemType($lineItemLineItemType)
        ->setRate($lineItemRate)
        ->setCostType($lineItemCostType)
        ->setCreativePlaceholders($lineItemCreativePlaceholders)
        ->setTargeting($lineItemTargeting);
    $request = (new UpdateLineItemRequest())
        ->setLineItem($lineItem);

    // Call the API and handle any network failures.
    try {
        /** @var LineItem $response */
        $response = $lineItemServiceClient->updateLineItem($request);
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
    $formattedLineItemOrder = LineItemServiceClient::orderName('[NETWORK_CODE]', '[ORDER]');
    $lineItemDisplayName = '[DISPLAY_NAME]';
    $lineItemCreativeRotationType = CreativeRotationType::CREATIVE_ROTATION_TYPE_UNSPECIFIED;
    $lineItemLineItemType = LineItemType::LINE_ITEM_TYPE_UNSPECIFIED;
    $lineItemCostType = LineItemCostType::LINE_ITEM_COST_TYPE_UNSPECIFIED;
    $lineItemCreativePlaceholdersSizeWidth = 0;
    $lineItemCreativePlaceholdersSizeHeight = 0;
    $lineItemCreativePlaceholdersSizeSizeType = SizeType::SIZE_TYPE_UNSPECIFIED;

    update_line_item_sample(
        $formattedLineItemOrder,
        $lineItemDisplayName,
        $lineItemCreativeRotationType,
        $lineItemLineItemType,
        $lineItemCostType,
        $lineItemCreativePlaceholdersSizeWidth,
        $lineItemCreativePlaceholdersSizeHeight,
        $lineItemCreativePlaceholdersSizeSizeType
    );
}
// [END admanager_v1_generated_LineItemService_UpdateLineItem_sync]
