<?php
/*
 * Copyright 2026 Google LLC
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

// [START discoveryengine_v1_generated_DataConnectorService_SetUpDataConnector_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\DataConnectorServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DataConnector;
use Google\Cloud\DiscoveryEngine\V1\SetUpDataConnectorRequest;
use Google\Protobuf\Duration;
use Google\Rpc\Status;

/**
 * Creates a [Collection][google.cloud.discoveryengine.v1.Collection] and sets
 * up the [DataConnector][google.cloud.discoveryengine.v1.DataConnector] for
 * it. To stop a
 * [DataConnector][google.cloud.discoveryengine.v1.DataConnector] after setup,
 * use the
 * [CollectionService.DeleteCollection][google.cloud.discoveryengine.v1.CollectionService.DeleteCollection]
 * method.
 *
 * @param string $formattedParent         The parent of
 *                                        [Collection][google.cloud.discoveryengine.v1.Collection], in the format of
 *                                        `projects/{project}/locations/{location}`. Please see
 *                                        {@see DataConnectorServiceClient::locationName()} for help formatting this field.
 * @param string $collectionId            The ID to use for the
 *                                        [Collection][google.cloud.discoveryengine.v1.Collection], which will become
 *                                        the final component of the
 *                                        [Collection][google.cloud.discoveryengine.v1.Collection]'s resource name. A
 *                                        new [Collection][google.cloud.discoveryengine.v1.Collection] is created as
 *                                        part of the [DataConnector][google.cloud.discoveryengine.v1.DataConnector]
 *                                        setup. [DataConnector][google.cloud.discoveryengine.v1.DataConnector] is a
 *                                        singleton resource under
 *                                        [Collection][google.cloud.discoveryengine.v1.Collection], managing all
 *                                        [DataStore][google.cloud.discoveryengine.v1.DataStore]s of the
 *                                        [Collection][google.cloud.discoveryengine.v1.Collection].
 *
 *                                        Should conform to
 *                                        [RFC-1034](https://tools.ietf.org/html/rfc1034) standard with a length
 *                                        limit of 63 characters. Otherwise, an `INVALID_ARGUMENT` error is returned.
 * @param string $collectionDisplayName   The display name of the
 *                                        [Collection][google.cloud.discoveryengine.v1.Collection].
 *
 *                                        Should be human readable, used to display collections in the Console
 *                                        Dashboard. UTF-8 encoded string with limit of 1024 characters.
 * @param string $dataConnectorDataSource The identifier for the data source.
 *                                        For the full, up-to-date list of supported connectors and their values,
 *                                        see
 *                                        [Connect a third-party data
 *                                        source](https://docs.cloud.google.com/gemini/enterprise/docs/connectors/connect-third-party-data-source#sources-by-launch-stage).
 */
function set_up_data_connector_sample(
    string $formattedParent,
    string $collectionId,
    string $collectionDisplayName,
    string $dataConnectorDataSource
): void {
    // Create a client.
    $dataConnectorServiceClient = new DataConnectorServiceClient();

    // Prepare the request message.
    $dataConnectorRefreshInterval = new Duration();
    $dataConnector = (new DataConnector())
        ->setDataSource($dataConnectorDataSource)
        ->setRefreshInterval($dataConnectorRefreshInterval);
    $request = (new SetUpDataConnectorRequest())
        ->setParent($formattedParent)
        ->setCollectionId($collectionId)
        ->setCollectionDisplayName($collectionDisplayName)
        ->setDataConnector($dataConnector);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataConnectorServiceClient->setUpDataConnector($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DataConnector $result */
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
    $formattedParent = DataConnectorServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $collectionId = '[COLLECTION_ID]';
    $collectionDisplayName = '[COLLECTION_DISPLAY_NAME]';
    $dataConnectorDataSource = '[DATA_SOURCE]';

    set_up_data_connector_sample(
        $formattedParent,
        $collectionId,
        $collectionDisplayName,
        $dataConnectorDataSource
    );
}
// [END discoveryengine_v1_generated_DataConnectorService_SetUpDataConnector_sync]
