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

// [START appengine_v1_generated_Applications_RepairApplication_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppEngine\V1\Application;
use Google\Cloud\AppEngine\V1\ApplicationsClient;
use Google\Rpc\Status;

/**
 * Recreates the required App Engine features for the specified App Engine
 * application, for example a Cloud Storage bucket or App Engine service
 * account.
 * Use this method if you receive an error message about a missing feature,
 * for example, *Error retrieving the App Engine service account*.
 * If you have deleted your App Engine service account, this will
 * not be able to recreate it. Instead, you should attempt to use the
 * IAM undelete API if possible at https://cloud.google.com/iam/reference/rest/v1/projects.serviceAccounts/undelete?apix_params=%7B"name"%3A"projects%2F-%2FserviceAccounts%2Funique_id"%2C"resource"%3A%7B%7D%7D .
 * If the deletion was recent, the numeric ID can be found in the Cloud
 * Console Activity Log.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function repair_application_sample(): void
{
    // Create a client.
    $applicationsClient = new ApplicationsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $applicationsClient->repairApplication();
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Application $result */
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
// [END appengine_v1_generated_Applications_RepairApplication_sync]
