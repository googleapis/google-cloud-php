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

// [START admanager_v1_generated_LineItemService_BatchCreateLineItems_sync]
use Google\Ads\AdManager\V1\BatchCreateLineItemsRequest;
use Google\Ads\AdManager\V1\BatchCreateLineItemsResponse;
use Google\Ads\AdManager\V1\Client\LineItemServiceClient;
use Google\Ads\AdManager\V1\CreateLineItemRequest;
use Google\Ads\AdManager\V1\CreativePlaceholder;
use Google\Ads\AdManager\V1\CreativeRotationTypeEnum\CreativeRotationType;
use Google\Ads\AdManager\V1\LineItem;
use Google\Ads\AdManager\V1\LineItemCostTypeEnum\LineItemCostType;
use Google\Ads\AdManager\V1\LineItemTypeEnum\LineItemType;
use Google\Ads\AdManager\V1\Size;
use Google\Ads\AdManager\V1\SizeTypeEnum\SizeType;
use Google\Ads\AdManager\V1\Targeting;
use Google\ApiCore\ApiException;
use Google\Protobuf\Timestamp;
use Google\Type\Money;

/**
 * Creates `LineItem` objects.
 *
 * @param string $formattedParent                                  The parent resource where `LineItems` will be created.
 *                                                                 Format: `networks/{network_code}`
 *                                                                 The parent field in the CreateLineItemRequest must match this
 *                                                                 field. Please see
 *                                                                 {@see LineItemServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent                          The parent resource where this `LineItem` will be created.
 *                                                                 Format: `networks/{network_code}`
 *                                                                 Please see {@see LineItemServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsLineItemOrder                   Immutable. The ID of the Order to which the LineItem belongs.
 *                                                                 Format: `networks/{network_code}/orders/{order}`
 *                                                                 Please see {@see LineItemServiceClient::orderName()} for help formatting this field.
 * @param string $requestsLineItemDisplayName                      The name of the line item. This attribute has a maximum length of
 *                                                                 255 characters.
 * @param int    $requestsLineItemCreativeRotationType             The strategy used for displaying multiple Creative objects that
 *                                                                 are associated with the LineItem.
 * @param int    $requestsLineItemLineItemType                     Indicates the line item type of a LineItem. The line item type
 *                                                                 determines the default priority of the line item. More information can be
 *                                                                 found at https://support.google.com/admanager/answer/177279.
 * @param int    $requestsLineItemCostType                         The method used for billing this LineItem.
 * @param int    $requestsLineItemCreativePlaceholdersSizeWidth    The width of the Creative,
 *                                                                 [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $requestsLineItemCreativePlaceholdersSizeHeight   The height of the Creative,
 *                                                                 [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 * @param int    $requestsLineItemCreativePlaceholdersSizeSizeType The SizeType of the Creative,
 *                                                                 [AdUnit][google.ads.admanager.v1.AdUnit], or LineItem.
 */
function batch_create_line_items_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $formattedRequestsLineItemOrder,
    string $requestsLineItemDisplayName,
    int $requestsLineItemCreativeRotationType,
    int $requestsLineItemLineItemType,
    int $requestsLineItemCostType,
    int $requestsLineItemCreativePlaceholdersSizeWidth,
    int $requestsLineItemCreativePlaceholdersSizeHeight,
    int $requestsLineItemCreativePlaceholdersSizeSizeType
): void {
    // Create a client.
    $lineItemServiceClient = new LineItemServiceClient();

    // Prepare the request message.
    $requestsLineItemStartTime = new Timestamp();
    $requestsLineItemRate = new Money();
    $requestsLineItemCreativePlaceholdersSize = (new Size())
        ->setWidth($requestsLineItemCreativePlaceholdersSizeWidth)
        ->setHeight($requestsLineItemCreativePlaceholdersSizeHeight)
        ->setSizeType($requestsLineItemCreativePlaceholdersSizeSizeType);
    $creativePlaceholder = (new CreativePlaceholder())
        ->setSize($requestsLineItemCreativePlaceholdersSize);
    $requestsLineItemCreativePlaceholders = [$creativePlaceholder,];
    $requestsLineItemTargeting = new Targeting();
    $requestsLineItem = (new LineItem())
        ->setOrder($formattedRequestsLineItemOrder)
        ->setDisplayName($requestsLineItemDisplayName)
        ->setStartTime($requestsLineItemStartTime)
        ->setCreativeRotationType($requestsLineItemCreativeRotationType)
        ->setLineItemType($requestsLineItemLineItemType)
        ->setRate($requestsLineItemRate)
        ->setCostType($requestsLineItemCostType)
        ->setCreativePlaceholders($requestsLineItemCreativePlaceholders)
        ->setTargeting($requestsLineItemTargeting);
    $createLineItemRequest = (new CreateLineItemRequest())
        ->setParent($formattedRequestsParent)
        ->setLineItem($requestsLineItem);
    $requests = [$createLineItemRequest,];
    $request = (new BatchCreateLineItemsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateLineItemsResponse $response */
        $response = $lineItemServiceClient->batchCreateLineItems($request);
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
    $formattedParent = LineItemServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = LineItemServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsLineItemOrder = LineItemServiceClient::orderName('[NETWORK_CODE]', '[ORDER]');
    $requestsLineItemDisplayName = '[DISPLAY_NAME]';
    $requestsLineItemCreativeRotationType = CreativeRotationType::CREATIVE_ROTATION_TYPE_UNSPECIFIED;
    $requestsLineItemLineItemType = LineItemType::LINE_ITEM_TYPE_UNSPECIFIED;
    $requestsLineItemCostType = LineItemCostType::LINE_ITEM_COST_TYPE_UNSPECIFIED;
    $requestsLineItemCreativePlaceholdersSizeWidth = 0;
    $requestsLineItemCreativePlaceholdersSizeHeight = 0;
    $requestsLineItemCreativePlaceholdersSizeSizeType = SizeType::SIZE_TYPE_UNSPECIFIED;

    batch_create_line_items_sample(
        $formattedParent,
        $formattedRequestsParent,
        $formattedRequestsLineItemOrder,
        $requestsLineItemDisplayName,
        $requestsLineItemCreativeRotationType,
        $requestsLineItemLineItemType,
        $requestsLineItemCostType,
        $requestsLineItemCreativePlaceholdersSizeWidth,
        $requestsLineItemCreativePlaceholdersSizeHeight,
        $requestsLineItemCreativePlaceholdersSizeSizeType
    );
}
// [END admanager_v1_generated_LineItemService_BatchCreateLineItems_sync]
