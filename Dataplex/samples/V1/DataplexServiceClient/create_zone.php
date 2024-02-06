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

// [START dataplex_v1_generated_DataplexService_CreateZone_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataplexServiceClient;
use Google\Cloud\Dataplex\V1\CreateZoneRequest;
use Google\Cloud\Dataplex\V1\Zone;
use Google\Cloud\Dataplex\V1\Zone\ResourceSpec;
use Google\Cloud\Dataplex\V1\Zone\ResourceSpec\LocationType;
use Google\Cloud\Dataplex\V1\Zone\Type;
use Google\Rpc\Status;

/**
 * Creates a zone resource within a lake.
 *
 * @param string $formattedParent              The resource name of the parent lake:
 *                                             `projects/{project_number}/locations/{location_id}/lakes/{lake_id}`. Please see
 *                                             {@see DataplexServiceClient::lakeName()} for help formatting this field.
 * @param string $zoneId                       Zone identifier.
 *                                             This ID will be used to generate names such as database and dataset names
 *                                             when publishing metadata to Hive Metastore and BigQuery.
 *                                             * Must contain only lowercase letters, numbers and hyphens.
 *                                             * Must start with a letter.
 *                                             * Must end with a number or a letter.
 *                                             * Must be between 1-63 characters.
 *                                             * Must be unique across all lakes from all locations in a project.
 *                                             * Must not be one of the reserved IDs (i.e. "default", "global-temp")
 * @param int    $zoneType                     Immutable. The type of the zone.
 * @param int    $zoneResourceSpecLocationType Immutable. The location type of the resources that are allowed
 *                                             to be attached to the assets within this zone.
 */
function create_zone_sample(
    string $formattedParent,
    string $zoneId,
    int $zoneType,
    int $zoneResourceSpecLocationType
): void {
    // Create a client.
    $dataplexServiceClient = new DataplexServiceClient();

    // Prepare the request message.
    $zoneResourceSpec = (new ResourceSpec())
        ->setLocationType($zoneResourceSpecLocationType);
    $zone = (new Zone())
        ->setType($zoneType)
        ->setResourceSpec($zoneResourceSpec);
    $request = (new CreateZoneRequest())
        ->setParent($formattedParent)
        ->setZoneId($zoneId)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataplexServiceClient->createZone($request);
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
    $formattedParent = DataplexServiceClient::lakeName('[PROJECT]', '[LOCATION]', '[LAKE]');
    $zoneId = '[ZONE_ID]';
    $zoneType = Type::TYPE_UNSPECIFIED;
    $zoneResourceSpecLocationType = LocationType::LOCATION_TYPE_UNSPECIFIED;

    create_zone_sample($formattedParent, $zoneId, $zoneType, $zoneResourceSpecLocationType);
}
// [END dataplex_v1_generated_DataplexService_CreateZone_sync]
