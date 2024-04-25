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

// [START datacatalog_v1_generated_DataCatalog_ReconcileTags_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DataCatalog\V1\Client\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\ReconcileTagsRequest;
use Google\Cloud\DataCatalog\V1\ReconcileTagsResponse;
use Google\Rpc\Status;

/**
 * `ReconcileTags` creates or updates a list of tags on the entry.
 * If the
 * [ReconcileTagsRequest.force_delete_missing][google.cloud.datacatalog.v1.ReconcileTagsRequest.force_delete_missing]
 * parameter is set, the operation deletes tags not included in the input tag
 * list.
 *
 * `ReconcileTags` returns a [long-running operation]
 * [google.longrunning.Operation] resource that can be queried with
 * [Operations.GetOperation][google.longrunning.Operations.GetOperation]
 * to return [ReconcileTagsMetadata]
 * [google.cloud.datacatalog.v1.ReconcileTagsMetadata] and
 * a [ReconcileTagsResponse]
 * [google.cloud.datacatalog.v1.ReconcileTagsResponse] message.
 *
 * @param string $formattedParent      Name of [Entry][google.cloud.datacatalog.v1.Entry] to be tagged. Please see
 *                                     {@see DataCatalogClient::entryName()} for help formatting this field.
 * @param string $formattedTagTemplate The name of the tag template, which is used for reconciliation. Please see
 *                                     {@see DataCatalogClient::tagTemplateName()} for help formatting this field.
 */
function reconcile_tags_sample(string $formattedParent, string $formattedTagTemplate): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare the request message.
    $request = (new ReconcileTagsRequest())
        ->setParent($formattedParent)
        ->setTagTemplate($formattedTagTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataCatalogClient->reconcileTags($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ReconcileTagsResponse $result */
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
    $formattedParent = DataCatalogClient::entryName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENTRY_GROUP]',
        '[ENTRY]'
    );
    $formattedTagTemplate = DataCatalogClient::tagTemplateName(
        '[PROJECT]',
        '[LOCATION]',
        '[TAG_TEMPLATE]'
    );

    reconcile_tags_sample($formattedParent, $formattedTagTemplate);
}
// [END datacatalog_v1_generated_DataCatalog_ReconcileTags_sync]
