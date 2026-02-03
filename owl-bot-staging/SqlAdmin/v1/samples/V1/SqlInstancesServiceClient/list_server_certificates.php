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

// [START sqladmin_v1_generated_SqlInstancesService_ListServerCertificates_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\Client\SqlInstancesServiceClient;
use Google\Cloud\Sql\V1\InstancesListServerCertificatesResponse;
use Google\Cloud\Sql\V1\SqlInstancesListServerCertificatesRequest;

/**
 * Lists all versions of server certificates and certificate authorities (CAs)
 * for the specified instance. There can be up to three sets of certs listed:
 * the certificate that is currently in use, a future that has been added but
 * not yet used to sign a certificate, and a certificate that has been rotated
 * out. For instances not using Certificate Authority Service (CAS) server CA,
 * use ListServerCas instead.
 *
 * @param string $instance Cloud SQL instance ID. This does not include the project ID.
 * @param string $project  Project ID of the project that contains the instance.
 */
function list_server_certificates_sample(string $instance, string $project): void
{
    // Create a client.
    $sqlInstancesServiceClient = new SqlInstancesServiceClient();

    // Prepare the request message.
    $request = (new SqlInstancesListServerCertificatesRequest())
        ->setInstance($instance)
        ->setProject($project);

    // Call the API and handle any network failures.
    try {
        /** @var InstancesListServerCertificatesResponse $response */
        $response = $sqlInstancesServiceClient->listServerCertificates($request);
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
    $instance = '[INSTANCE]';
    $project = '[PROJECT]';

    list_server_certificates_sample($instance, $project);
}
// [END sqladmin_v1_generated_SqlInstancesService_ListServerCertificates_sync]
