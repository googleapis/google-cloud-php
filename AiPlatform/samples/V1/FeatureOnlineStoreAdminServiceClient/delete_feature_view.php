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

// [START aiplatform_v1_generated_FeatureOnlineStoreAdminService_DeleteFeatureView_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\FeatureOnlineStoreAdminServiceClient;
use Google\Cloud\AIPlatform\V1\DeleteFeatureViewRequest;
use Google\Rpc\Status;

/**
 * Deletes a single FeatureView.
 *
 * @param string $formattedName The name of the FeatureView to be deleted.
 *                              Format:
 *                              `projects/{project}/locations/{location}/featureOnlineStores/{feature_online_store}/featureViews/{feature_view}`
 *                              Please see {@see FeatureOnlineStoreAdminServiceClient::featureViewName()} for help formatting this field.
 */
function delete_feature_view_sample(string $formattedName): void
{
    // Create a client.
    $featureOnlineStoreAdminServiceClient = new FeatureOnlineStoreAdminServiceClient();

    // Prepare the request message.
    $request = (new DeleteFeatureViewRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $featureOnlineStoreAdminServiceClient->deleteFeatureView($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = FeatureOnlineStoreAdminServiceClient::featureViewName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURE_ONLINE_STORE]',
        '[FEATURE_VIEW]'
    );

    delete_feature_view_sample($formattedName);
}
// [END aiplatform_v1_generated_FeatureOnlineStoreAdminService_DeleteFeatureView_sync]
