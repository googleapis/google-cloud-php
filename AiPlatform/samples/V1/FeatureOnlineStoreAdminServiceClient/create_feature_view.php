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

// [START aiplatform_v1_generated_FeatureOnlineStoreAdminService_CreateFeatureView_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\FeatureOnlineStoreAdminServiceClient;
use Google\Cloud\AIPlatform\V1\CreateFeatureViewRequest;
use Google\Cloud\AIPlatform\V1\FeatureView;
use Google\Rpc\Status;

/**
 * Creates a new FeatureView in a given FeatureOnlineStore.
 *
 * @param string $formattedParent The resource name of the FeatureOnlineStore to create
 *                                FeatureViews. Format:
 *                                `projects/{project}/locations/{location}/featureOnlineStores/{feature_online_store}`
 *                                Please see {@see FeatureOnlineStoreAdminServiceClient::featureOnlineStoreName()} for help formatting this field.
 * @param string $featureViewId   The ID to use for the FeatureView, which will become the final
 *                                component of the FeatureView's resource name.
 *
 *                                This value may be up to 60 characters, and valid characters are
 *                                `[a-z0-9_]`. The first character cannot be a number.
 *
 *                                The value must be unique within a FeatureOnlineStore.
 */
function create_feature_view_sample(string $formattedParent, string $featureViewId): void
{
    // Create a client.
    $featureOnlineStoreAdminServiceClient = new FeatureOnlineStoreAdminServiceClient();

    // Prepare the request message.
    $featureView = new FeatureView();
    $request = (new CreateFeatureViewRequest())
        ->setParent($formattedParent)
        ->setFeatureView($featureView)
        ->setFeatureViewId($featureViewId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $featureOnlineStoreAdminServiceClient->createFeatureView($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var FeatureView $result */
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
    $formattedParent = FeatureOnlineStoreAdminServiceClient::featureOnlineStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURE_ONLINE_STORE]'
    );
    $featureViewId = '[FEATURE_VIEW_ID]';

    create_feature_view_sample($formattedParent, $featureViewId);
}
// [END aiplatform_v1_generated_FeatureOnlineStoreAdminService_CreateFeatureView_sync]
