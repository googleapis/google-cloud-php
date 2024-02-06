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

// [START aiplatform_v1_generated_FeaturestoreService_DeleteFeatureValues_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\FeaturestoreServiceClient;
use Google\Cloud\AIPlatform\V1\DeleteFeatureValuesRequest;
use Google\Cloud\AIPlatform\V1\DeleteFeatureValuesResponse;
use Google\Rpc\Status;

/**
 * Delete Feature values from Featurestore.
 *
 * The progress of the deletion is tracked by the returned operation. The
 * deleted feature values are guaranteed to be invisible to subsequent read
 * operations after the operation is marked as successfully done.
 *
 * If a delete feature values operation fails, the feature values
 * returned from reads and exports may be inconsistent. If consistency is
 * required, the caller must retry the same delete request again and wait till
 * the new operation returned is marked as successfully done.
 *
 * @param string $formattedEntityType The resource name of the EntityType grouping the Features for
 *                                    which values are being deleted from. Format:
 *                                    `projects/{project}/locations/{location}/featurestores/{featurestore}/entityTypes/{entityType}`
 *                                    Please see {@see FeaturestoreServiceClient::entityTypeName()} for help formatting this field.
 */
function delete_feature_values_sample(string $formattedEntityType): void
{
    // Create a client.
    $featurestoreServiceClient = new FeaturestoreServiceClient();

    // Prepare the request message.
    $request = (new DeleteFeatureValuesRequest())
        ->setEntityType($formattedEntityType);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $featurestoreServiceClient->deleteFeatureValues($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DeleteFeatureValuesResponse $result */
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

    delete_feature_values_sample($formattedEntityType);
}
// [END aiplatform_v1_generated_FeaturestoreService_DeleteFeatureValues_sync]
