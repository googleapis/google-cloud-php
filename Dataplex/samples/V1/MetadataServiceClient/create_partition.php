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

// [START dataplex_v1_generated_MetadataService_CreatePartition_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\MetadataServiceClient;
use Google\Cloud\Dataplex\V1\CreatePartitionRequest;
use Google\Cloud\Dataplex\V1\Partition;

/**
 * Create a metadata partition.
 *
 * @param string $formattedParent        The resource name of the parent zone:
 *                                       `projects/{project_number}/locations/{location_id}/lakes/{lake_id}/zones/{zone_id}/entities/{entity_id}`. Please see
 *                                       {@see MetadataServiceClient::entityName()} for help formatting this field.
 * @param string $partitionValuesElement Immutable. The set of values representing the partition, which
 *                                       correspond to the partition schema defined in the parent entity.
 * @param string $partitionLocation      Immutable. The location of the entity data within the partition,
 *                                       for example, `gs://bucket/path/to/entity/key1=value1/key2=value2`. Or
 *                                       `projects/<project_id>/datasets/<dataset_id>/tables/<table_id>`
 */
function create_partition_sample(
    string $formattedParent,
    string $partitionValuesElement,
    string $partitionLocation
): void {
    // Create a client.
    $metadataServiceClient = new MetadataServiceClient();

    // Prepare the request message.
    $partitionValues = [$partitionValuesElement,];
    $partition = (new Partition())
        ->setValues($partitionValues)
        ->setLocation($partitionLocation);
    $request = (new CreatePartitionRequest())
        ->setParent($formattedParent)
        ->setPartition($partition);

    // Call the API and handle any network failures.
    try {
        /** @var Partition $response */
        $response = $metadataServiceClient->createPartition($request);
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
    $formattedParent = MetadataServiceClient::entityName(
        '[PROJECT]',
        '[LOCATION]',
        '[LAKE]',
        '[ZONE]',
        '[ENTITY]'
    );
    $partitionValuesElement = '[VALUES]';
    $partitionLocation = '[LOCATION]';

    create_partition_sample($formattedParent, $partitionValuesElement, $partitionLocation);
}
// [END dataplex_v1_generated_MetadataService_CreatePartition_sync]
