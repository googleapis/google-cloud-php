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

// [START dataplex_v1_generated_MetadataService_CreateEntity_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\MetadataServiceClient;
use Google\Cloud\Dataplex\V1\CreateEntityRequest;
use Google\Cloud\Dataplex\V1\Entity;
use Google\Cloud\Dataplex\V1\Entity\Type;
use Google\Cloud\Dataplex\V1\Schema;
use Google\Cloud\Dataplex\V1\StorageFormat;
use Google\Cloud\Dataplex\V1\StorageSystem;

/**
 * Create a metadata entity.
 *
 * @param string $formattedParent         The resource name of the parent zone:
 *                                        `projects/{project_number}/locations/{location_id}/lakes/{lake_id}/zones/{zone_id}`. Please see
 *                                        {@see MetadataServiceClient::zoneName()} for help formatting this field.
 * @param string $entityId                A user-provided entity ID. It is mutable, and will be used as the
 *                                        published table name. Specifying a new ID in an update entity
 *                                        request will override the existing value.
 *                                        The ID must contain only letters (a-z, A-Z), numbers (0-9), and
 *                                        underscores, and consist of 256 or fewer characters.
 * @param int    $entityType              Immutable. The type of entity.
 * @param string $entityAsset             Immutable. The ID of the asset associated with the storage
 *                                        location containing the entity data. The entity must be with in the same
 *                                        zone with the asset.
 * @param string $entityDataPath          Immutable. The storage path of the entity data.
 *                                        For Cloud Storage data, this is the fully-qualified path to the entity,
 *                                        such as `gs://bucket/path/to/data`. For BigQuery data, this is the name of
 *                                        the table resource, such as
 *                                        `projects/project_id/datasets/dataset_id/tables/table_id`.
 * @param int    $entitySystem            Immutable. Identifies the storage system of the entity data.
 * @param string $entityFormatMimeType    The mime type descriptor for the data. Must match the pattern
 *                                        {type}/{subtype}. Supported values:
 *
 *                                        - application/x-parquet
 *                                        - application/x-avro
 *                                        - application/x-orc
 *                                        - application/x-tfrecord
 *                                        - application/x-parquet+iceberg
 *                                        - application/x-avro+iceberg
 *                                        - application/x-orc+iceberg
 *                                        - application/json
 *                                        - application/{subtypes}
 *                                        - text/csv
 *                                        - text/<subtypes>
 *                                        - image/{image subtype}
 *                                        - video/{video subtype}
 *                                        - audio/{audio subtype}
 * @param bool   $entitySchemaUserManaged Set to `true` if user-managed or `false` if managed by Dataplex.
 *                                        The default is `false` (managed by Dataplex).
 *
 *                                        - Set to `false`to enable Dataplex discovery to update the schema.
 *                                        including new data discovery, schema inference, and schema evolution.
 *                                        Users retain the ability to input and edit the schema. Dataplex
 *                                        treats schema input by the user as though produced
 *                                        by a previous Dataplex discovery operation, and it will
 *                                        evolve the schema and take action based on that treatment.
 *
 *                                        - Set to `true` to fully manage the entity
 *                                        schema. This setting guarantees that Dataplex will not
 *                                        change schema fields.
 */
function create_entity_sample(
    string $formattedParent,
    string $entityId,
    int $entityType,
    string $entityAsset,
    string $entityDataPath,
    int $entitySystem,
    string $entityFormatMimeType,
    bool $entitySchemaUserManaged
): void {
    // Create a client.
    $metadataServiceClient = new MetadataServiceClient();

    // Prepare the request message.
    $entityFormat = (new StorageFormat())
        ->setMimeType($entityFormatMimeType);
    $entitySchema = (new Schema())
        ->setUserManaged($entitySchemaUserManaged);
    $entity = (new Entity())
        ->setId($entityId)
        ->setType($entityType)
        ->setAsset($entityAsset)
        ->setDataPath($entityDataPath)
        ->setSystem($entitySystem)
        ->setFormat($entityFormat)
        ->setSchema($entitySchema);
    $request = (new CreateEntityRequest())
        ->setParent($formattedParent)
        ->setEntity($entity);

    // Call the API and handle any network failures.
    try {
        /** @var Entity $response */
        $response = $metadataServiceClient->createEntity($request);
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
    $formattedParent = MetadataServiceClient::zoneName('[PROJECT]', '[LOCATION]', '[LAKE]', '[ZONE]');
    $entityId = '[ID]';
    $entityType = Type::TYPE_UNSPECIFIED;
    $entityAsset = '[ASSET]';
    $entityDataPath = '[DATA_PATH]';
    $entitySystem = StorageSystem::STORAGE_SYSTEM_UNSPECIFIED;
    $entityFormatMimeType = '[MIME_TYPE]';
    $entitySchemaUserManaged = false;

    create_entity_sample(
        $formattedParent,
        $entityId,
        $entityType,
        $entityAsset,
        $entityDataPath,
        $entitySystem,
        $entityFormatMimeType,
        $entitySchemaUserManaged
    );
}
// [END dataplex_v1_generated_MetadataService_CreateEntity_sync]
