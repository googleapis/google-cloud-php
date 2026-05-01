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

// [START chronicle_v1_generated_BigQueryExportService_ProvisionBigQueryExport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\BigQueryExport;
use Google\Cloud\Chronicle\V1\Client\BigQueryExportServiceClient;
use Google\Cloud\Chronicle\V1\ProvisionBigQueryExportRequest;

/**
 * Provision the BigQuery export for a Chronicle instance. This will create
 * {{gcp_name}} resources like {{storage_name}} buckets, BigQuery datasets
 * and set default export settings for each data source.
 *
 * @param string $formattedParent The instance for which BigQuery export is being provisioned.
 *                                Format: projects/{project}/locations/{location}/instances/{instance}
 *                                Please see {@see BigQueryExportServiceClient::instanceName()} for help formatting this field.
 */
function provision_big_query_export_sample(string $formattedParent): void
{
    // Create a client.
    $bigQueryExportServiceClient = new BigQueryExportServiceClient();

    // Prepare the request message.
    $request = (new ProvisionBigQueryExportRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var BigQueryExport $response */
        $response = $bigQueryExportServiceClient->provisionBigQueryExport($request);
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
    $formattedParent = BigQueryExportServiceClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]'
    );

    provision_big_query_export_sample($formattedParent);
}
// [END chronicle_v1_generated_BigQueryExportService_ProvisionBigQueryExport_sync]
