<?php
/*
 * Copyright 2022 Google LLC
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

// [START recommendationengine_v1beta1_generated_PredictionService_Predict_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\RecommendationEngine\V1beta1\Client\PredictionServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\PredictRequest;
use Google\Cloud\RecommendationEngine\V1beta1\PredictResponse\PredictionResult;
use Google\Cloud\RecommendationEngine\V1beta1\UserEvent;
use Google\Cloud\RecommendationEngine\V1beta1\UserInfo;

/**
 * Makes a recommendation prediction. If using API Key based authentication,
 * the API Key must be registered using the
 * [PredictionApiKeyRegistry][google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry]
 * service. [Learn more](/recommendations-ai/docs/setting-up#register-key).
 *
 * @param string $formattedName              Full resource name of the format:
 *                                           `{name=projects/&#42;/locations/global/catalogs/default_catalog/eventStores/default_event_store/placements/*}`
 *                                           The id of the recommendation engine placement. This id is used to identify
 *                                           the set of models that will be used to make the prediction.
 *
 *                                           We currently support three placements with the following IDs by default:
 *
 *                                           * `shopping_cart`: Predicts items frequently bought together with one or
 *                                           more catalog items in the same shopping session. Commonly displayed after
 *                                           `add-to-cart` events, on product detail pages, or on the shopping cart
 *                                           page.
 *
 *                                           * `home_page`: Predicts the next product that a user will most likely
 *                                           engage with or purchase based on the shopping or viewing history of the
 *                                           specified `userId` or `visitorId`. For example - Recommendations for you.
 *
 *                                           * `product_detail`: Predicts the next product that a user will most likely
 *                                           engage with or purchase. The prediction is based on the shopping or
 *                                           viewing history of the specified `userId` or `visitorId` and its
 *                                           relevance to a specified `CatalogItem`. Typically used on product detail
 *                                           pages. For example - More items like this.
 *
 *                                           * `recently_viewed_default`: Returns up to 75 items recently viewed by the
 *                                           specified `userId` or `visitorId`, most recent ones first. Returns
 *                                           nothing if neither of them has viewed any items yet. For example -
 *                                           Recently viewed.
 *
 *                                           The full list of available placements can be seen at
 *                                           https://console.cloud.google.com/recommendation/datafeeds/default_catalog/dashboard
 *                                           Please see {@see PredictionServiceClient::placementName()} for help formatting this field.
 * @param string $userEventEventType         User event type. Allowed values are:
 *
 *                                           * `add-to-cart` Products being added to cart.
 *                                           * `add-to-list` Items being added to a list (shopping list, favorites
 *                                           etc).
 *                                           * `category-page-view` Special pages such as sale or promotion pages
 *                                           viewed.
 *                                           * `checkout-start` User starting a checkout process.
 *                                           * `detail-page-view` Products detail page viewed.
 *                                           * `home-page-view` Homepage viewed.
 *                                           * `page-visit` Generic page visits not included in the event types above.
 *                                           * `purchase-complete` User finishing a purchase.
 *                                           * `refund` Purchased items being refunded or returned.
 *                                           * `remove-from-cart` Products being removed from cart.
 *                                           * `remove-from-list` Items being removed from a list.
 *                                           * `search` Product search.
 *                                           * `shopping-cart-page-view` User viewing a shopping cart.
 *                                           * `impression` List of items displayed. Used by Google Tag Manager.
 * @param string $userEventUserInfoVisitorId A unique identifier for tracking visitors with a length limit of
 *                                           128 bytes.
 *
 *                                           For example, this could be implemented with a http cookie, which should be
 *                                           able to uniquely identify a visitor on a single device. This unique
 *                                           identifier should not change if the visitor log in/out of the website.
 *                                           Maximum length 128 bytes. Cannot be empty.
 */
function predict_sample(
    string $formattedName,
    string $userEventEventType,
    string $userEventUserInfoVisitorId
): void {
    // Create a client.
    $predictionServiceClient = new PredictionServiceClient();

    // Prepare the request message.
    $userEventUserInfo = (new UserInfo())
        ->setVisitorId($userEventUserInfoVisitorId);
    $userEvent = (new UserEvent())
        ->setEventType($userEventEventType)
        ->setUserInfo($userEventUserInfo);
    $request = (new PredictRequest())
        ->setName($formattedName)
        ->setUserEvent($userEvent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $predictionServiceClient->predict($request);

        /** @var PredictionResult $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedName = PredictionServiceClient::placementName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[EVENT_STORE]',
        '[PLACEMENT]'
    );
    $userEventEventType = '[EVENT_TYPE]';
    $userEventUserInfoVisitorId = '[VISITOR_ID]';

    predict_sample($formattedName, $userEventEventType, $userEventUserInfoVisitorId);
}
// [END recommendationengine_v1beta1_generated_PredictionService_Predict_sync]
