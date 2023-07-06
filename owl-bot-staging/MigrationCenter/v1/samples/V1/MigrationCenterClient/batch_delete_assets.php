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

// [START migrationcenter_v1_generated_MigrationCenter_BatchDeleteAssets_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\MigrationCenter\V1\BatchDeleteAssetsRequest;
use Google\Cloud\MigrationCenter\V1\Client\MigrationCenterClient;

/**
 * Deletes list of Assets.
 *
 * @param string $formattedParent       Parent value for batch asset delete. Please see
 *                                      {@see MigrationCenterClient::locationName()} for help formatting this field.
 * @param string $formattedNamesElement The IDs of the assets to delete.
 *                                      A maximum of 1000 assets can be deleted in a batch.
 *                                      Format: projects/{project}/locations/{location}/assets/{name}. Please see
 *                                      {@see MigrationCenterClient::assetName()} for help formatting this field.
 */
function batch_delete_assets_sample(string $formattedParent, string $formattedNamesElement): void
{
    // Create a client.
    $migrationCenterClient = new MigrationCenterClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchDeleteAssetsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        $migrationCenterClient->batchDeleteAssets($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedNamesElement = MigrationCenterClient::assetName('[PROJECT]', '[LOCATION]', '[ASSET]');

    batch_delete_assets_sample($formattedParent, $formattedNamesElement);
}
// [END migrationcenter_v1_generated_MigrationCenter_BatchDeleteAssets_sync]
