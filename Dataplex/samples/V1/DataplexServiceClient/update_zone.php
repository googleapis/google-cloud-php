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

// [START dataplex_v1_generated_DataplexService_UpdateZone_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataplexServiceClient;
use Google\Cloud\Dataplex\V1\UpdateZoneRequest;
use Google\Cloud\Dataplex\V1\Zone;
use Google\Cloud\Dataplex\V1\Zone\ResourceSpec;
use Google\Cloud\Dataplex\V1\Zone\ResourceSpec\LocationType;
use Google\Cloud\Dataplex\V1\Zone\Type;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a zone resource.
 *
 * @param int $zoneType                     Immutable. The type of the zone.
 * @param int $zoneResourceSpecLocationType Immutable. The location type of the resources that are allowed
 *                                          to be attached to the assets within this zone.
 */
function update_zone_sample(int $zoneType, int $zoneResourceSpecLocationType): void
{
    // Create a client.
    $dataplexServiceClient = new DataplexServiceClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $zoneResourceSpec = (new ResourceSpec())
        ->setLocationType($zoneResourceSpecLocationType);
    $zone = (new Zone())
        ->setType($zoneType)
        ->setResourceSpec($zoneResourceSpec);
    $request = (new UpdateZoneRequest())
        ->setUpdateMask($updateMask)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataplexServiceClient->updateZone($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Zone $result */
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
    $zoneType = Type::TYPE_UNSPECIFIED;
    $zoneResourceSpecLocationType = LocationType::LOCATION_TYPE_UNSPECIFIED;

    update_zone_sample($zoneType, $zoneResourceSpecLocationType);
}
// [END dataplex_v1_generated_DataplexService_UpdateZone_sync]
