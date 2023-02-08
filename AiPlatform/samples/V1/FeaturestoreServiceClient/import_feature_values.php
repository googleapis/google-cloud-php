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

// [START aiplatform_v1_generated_FeaturestoreService_ImportFeatureValues_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\FeaturestoreServiceClient;
use Google\Cloud\AIPlatform\V1\ImportFeatureValuesRequest\FeatureSpec;
use Google\Cloud\AIPlatform\V1\ImportFeatureValuesResponse;
use Google\Rpc\Status;

/**
 * Imports Feature values into the Featurestore from a source storage.
 *
 * The progress of the import is tracked by the returned operation. The
 * imported features are guaranteed to be visible to subsequent read
 * operations after the operation is marked as successfully done.
 *
 * If an import operation fails, the Feature values returned from
 * reads and exports may be inconsistent. If consistency is
 * required, the caller must retry the same import request again and wait till
 * the new operation returned is marked as successfully done.
 *
 * There are also scenarios where the caller can cause inconsistency.
 *
 * - Source data for import contains multiple distinct Feature values for
 * the same entity ID and timestamp.
 * - Source is modified during an import. This includes adding, updating, or
 * removing source data and/or metadata. Examples of updating metadata
 * include but are not limited to changing storage location, storage class,
 * or retention policy.
 * - Online serving cluster is under-provisioned.
 *
 * @param string $formattedEntityType The resource name of the EntityType grouping the Features for which values
 *                                    are being imported. Format:
 *                                    `projects/{project}/locations/{location}/featurestores/{featurestore}/entityTypes/{entityType}`
 *                                    Please see {@see FeaturestoreServiceClient::entityTypeName()} for help formatting this field.
 * @param string $featureSpecsId      ID of the Feature to import values of. This Feature must exist in the
 *                                    target EntityType, or the request will fail.
 */
function import_feature_values_sample(string $formattedEntityType, string $featureSpecsId): void
{
    // Create a client.
    $featurestoreServiceClient = new FeaturestoreServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $featureSpec = (new FeatureSpec())
        ->setId($featureSpecsId);
    $featureSpecs = [$featureSpec,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $featurestoreServiceClient->importFeatureValues($formattedEntityType, $featureSpecs);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportFeatureValuesResponse $result */
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
    $formattedEntityType = FeaturestoreServiceClient::entityTypeName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEATURESTORE]',
        '[ENTITY_TYPE]'
    );
    $featureSpecsId = '[ID]';

    import_feature_values_sample($formattedEntityType, $featureSpecsId);
}
// [END aiplatform_v1_generated_FeaturestoreService_ImportFeatureValues_sync]
