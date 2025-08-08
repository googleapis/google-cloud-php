<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1_generated_PromotionsService_InsertPromotion_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Promotions\V1\Client\PromotionsServiceClient;
use Google\Shopping\Merchant\Promotions\V1\InsertPromotionRequest;
use Google\Shopping\Merchant\Promotions\V1\Promotion;
use Google\Shopping\Merchant\Promotions\V1\RedemptionChannel;

/**
 * Inserts a promotion for your Merchant Center account. If the promotion
 * already exists, then it updates the promotion instead.
 *
 * @param string $parent                            The account where the promotion will be inserted.
 *                                                  Format: accounts/{account}
 * @param string $promotionPromotionId              The user provided promotion ID to uniquely identify the
 *                                                  promotion. Follow [minimum
 *                                                  requirements](https://support.google.com/merchants/answer/7050148?ref_topic=7322920&sjid=871860036916537104-NC#minimum_requirements)
 *                                                  to prevent promotion disapprovals.
 * @param string $promotionContentLanguage          The two-letter [ISO
 *                                                  639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
 *                                                  promotion.
 *
 *                                                  Promotions is only for [selected
 *                                                  languages](https://support.google.com/merchants/answer/4588281?ref_topic=6396150&sjid=18314938579342094533-NC#option3&zippy=).
 * @param string $promotionTargetCountry            The target country used as part of the unique identifier.
 *                                                  Represented as a [CLDR territory
 *                                                  code](https://github.com/unicode-org/cldr/blob/latest/common/main/en.xml).
 *
 *                                                  Promotions are only available in selected
 *                                                  countries, [Free Listings and Shopping
 *                                                  ads](https://support.google.com/merchants/answer/4588460) [Local Inventory
 *                                                  ads](https://support.google.com/merchants/answer/10146326)
 * @param int    $promotionRedemptionChannelElement [Redemption
 *                                                  channel](https://support.google.com/merchants/answer/13837674?ref_topic=13773355&sjid=17642868584668136159-NC)
 *                                                  for the promotion. At least one channel is required.
 * @param string $dataSource                        The data source of the
 *                                                  [promotion](https://support.google.com/merchants/answer/6396268?sjid=5155774230887277618-NC)
 *                                                  Format:
 *                                                  `accounts/{account}/dataSources/{datasource}`.
 */
function insert_promotion_sample(
    string $parent,
    string $promotionPromotionId,
    string $promotionContentLanguage,
    string $promotionTargetCountry,
    int $promotionRedemptionChannelElement,
    string $dataSource
): void {
    // Create a client.
    $promotionsServiceClient = new PromotionsServiceClient();

    // Prepare the request message.
    $promotionRedemptionChannel = [$promotionRedemptionChannelElement,];
    $promotion = (new Promotion())
        ->setPromotionId($promotionPromotionId)
        ->setContentLanguage($promotionContentLanguage)
        ->setTargetCountry($promotionTargetCountry)
        ->setRedemptionChannel($promotionRedemptionChannel);
    $request = (new InsertPromotionRequest())
        ->setParent($parent)
        ->setPromotion($promotion)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        /** @var Promotion $response */
        $response = $promotionsServiceClient->insertPromotion($request);
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
    $parent = '[PARENT]';
    $promotionPromotionId = '[PROMOTION_ID]';
    $promotionContentLanguage = '[CONTENT_LANGUAGE]';
    $promotionTargetCountry = '[TARGET_COUNTRY]';
    $promotionRedemptionChannelElement = RedemptionChannel::REDEMPTION_CHANNEL_UNSPECIFIED;
    $dataSource = '[DATA_SOURCE]';

    insert_promotion_sample(
        $parent,
        $promotionPromotionId,
        $promotionContentLanguage,
        $promotionTargetCountry,
        $promotionRedemptionChannelElement,
        $dataSource
    );
}
// [END merchantapi_v1_generated_PromotionsService_InsertPromotion_sync]
