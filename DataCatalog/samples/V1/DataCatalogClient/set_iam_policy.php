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

// [START datacatalog_v1_generated_DataCatalog_SetIamPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;
use Google\Cloud\Iam\V1\Policy;

/**
 * Sets an access control policy for a resource. Replaces any existing
 * policy.
 *
 * Supported resources are:
 *
 * - Tag templates
 * - Entry groups
 *
 * Note: This method sets policies only within Data Catalog and can't be
 * used to manage policies in BigQuery, Pub/Sub, Dataproc Metastore, and any
 * external Google Cloud Platform resources synced with the Data Catalog.
 *
 * To call this method, you must have the following Google IAM permissions:
 *
 * - `datacatalog.tagTemplates.setIamPolicy` to set policies on tag
 * templates.
 * - `datacatalog.entryGroups.setIamPolicy` to set policies on entry groups.
 *
 * @param string $resource REQUIRED: The resource for which the policy is being specified.
 *                         See the operation documentation for the appropriate value for this field.
 */
function set_iam_policy_sample(string $resource): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $policy = new Policy();

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $dataCatalogClient->setIamPolicy($resource, $policy);
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
    $resource = '[RESOURCE]';

    set_iam_policy_sample($resource);
}
// [END datacatalog_v1_generated_DataCatalog_SetIamPolicy_sync]
