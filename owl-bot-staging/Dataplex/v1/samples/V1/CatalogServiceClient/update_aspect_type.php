<?php
/*
 * Copyright 2024 Google LLC
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

// [START dataplex_v1_generated_CatalogService_UpdateAspectType_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\AspectType;
use Google\Cloud\Dataplex\V1\AspectType\MetadataTemplate;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\UpdateAspectTypeRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a AspectType resource.
 *
 * @param string $aspectTypeMetadataTemplateName The name of the field.
 * @param string $aspectTypeMetadataTemplateType The datatype of this field. The following values are supported:
 *                                               Primitive types (string, integer, boolean, double, datetime); datetime
 *                                               must be of the format RFC3339 UTC "Zulu" (Examples:
 *                                               "2014-10-02T15:01:23Z" and "2014-10-02T15:01:23.045123456Z"). Complex
 *                                               types (enum, array, map, record).
 */
function update_aspect_type_sample(
    string $aspectTypeMetadataTemplateName,
    string $aspectTypeMetadataTemplateType
): void {
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $aspectTypeMetadataTemplate = (new MetadataTemplate())
        ->setName($aspectTypeMetadataTemplateName)
        ->setType($aspectTypeMetadataTemplateType);
    $aspectType = (new AspectType())
        ->setMetadataTemplate($aspectTypeMetadataTemplate);
    $updateMask = new FieldMask();
    $request = (new UpdateAspectTypeRequest())
        ->setAspectType($aspectType)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $catalogServiceClient->updateAspectType($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AspectType $result */
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
    $aspectTypeMetadataTemplateName = '[NAME]';
    $aspectTypeMetadataTemplateType = '[TYPE]';

    update_aspect_type_sample($aspectTypeMetadataTemplateName, $aspectTypeMetadataTemplateType);
}
// [END dataplex_v1_generated_CatalogService_UpdateAspectType_sync]
