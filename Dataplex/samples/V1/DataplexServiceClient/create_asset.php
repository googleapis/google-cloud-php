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

// [START dataplex_v1_generated_DataplexService_CreateAsset_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Asset;
use Google\Cloud\Dataplex\V1\Asset\ResourceSpec;
use Google\Cloud\Dataplex\V1\Asset\ResourceSpec\Type;
use Google\Cloud\Dataplex\V1\Client\DataplexServiceClient;
use Google\Cloud\Dataplex\V1\CreateAssetRequest;
use Google\Rpc\Status;

/**
 * Creates an asset resource.
 *
 * @param string $formattedParent       The resource name of the parent zone:
 *                                      `projects/{project_number}/locations/{location_id}/lakes/{lake_id}/zones/{zone_id}`. Please see
 *                                      {@see DataplexServiceClient::zoneName()} for help formatting this field.
 * @param string $assetId               Asset identifier.
 *                                      This ID will be used to generate names such as table names when publishing
 *                                      metadata to Hive Metastore and BigQuery.
 *                                      * Must contain only lowercase letters, numbers and hyphens.
 *                                      * Must start with a letter.
 *                                      * Must end with a number or a letter.
 *                                      * Must be between 1-63 characters.
 *                                      * Must be unique within the zone.
 * @param int    $assetResourceSpecType Immutable. Type of resource.
 */
function create_asset_sample(
    string $formattedParent,
    string $assetId,
    int $assetResourceSpecType
): void {
    // Create a client.
    $dataplexServiceClient = new DataplexServiceClient();

    // Prepare the request message.
    $assetResourceSpec = (new ResourceSpec())
        ->setType($assetResourceSpecType);
    $asset = (new Asset())
        ->setResourceSpec($assetResourceSpec);
    $request = (new CreateAssetRequest())
        ->setParent($formattedParent)
        ->setAssetId($assetId)
        ->setAsset($asset);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataplexServiceClient->createAsset($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Asset $result */
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
    $formattedParent = DataplexServiceClient::zoneName('[PROJECT]', '[LOCATION]', '[LAKE]', '[ZONE]');
    $assetId = '[ASSET_ID]';
    $assetResourceSpecType = Type::TYPE_UNSPECIFIED;

    create_asset_sample($formattedParent, $assetId, $assetResourceSpecType);
}
// [END dataplex_v1_generated_DataplexService_CreateAsset_sync]
