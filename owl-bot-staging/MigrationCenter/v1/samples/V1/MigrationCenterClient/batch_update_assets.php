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

// [START migrationcenter_v1_generated_MigrationCenter_BatchUpdateAssets_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\MigrationCenter\V1\Asset;
use Google\Cloud\MigrationCenter\V1\BatchUpdateAssetsRequest;
use Google\Cloud\MigrationCenter\V1\BatchUpdateAssetsResponse;
use Google\Cloud\MigrationCenter\V1\Client\MigrationCenterClient;
use Google\Cloud\MigrationCenter\V1\UpdateAssetRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates the parameters of a list of assets.
 *
 * @param string $formattedParent Parent value for batch asset update. Please see
 *                                {@see MigrationCenterClient::locationName()} for help formatting this field.
 */
function batch_update_assets_sample(string $formattedParent): void
{
    // Create a client.
    $migrationCenterClient = new MigrationCenterClient();

    // Prepare the request message.
    $requestsUpdateMask = new FieldMask();
    $requestsAsset = new Asset();
    $updateAssetRequest = (new UpdateAssetRequest())
        ->setUpdateMask($requestsUpdateMask)
        ->setAsset($requestsAsset);
    $requests = [$updateAssetRequest,];
    $request = (new BatchUpdateAssetsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateAssetsResponse $response */
        $response = $migrationCenterClient->batchUpdateAssets($request);
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
    $formattedParent = MigrationCenterClient::locationName('[PROJECT]', '[LOCATION]');

    batch_update_assets_sample($formattedParent);
}
// [END migrationcenter_v1_generated_MigrationCenter_BatchUpdateAssets_sync]
