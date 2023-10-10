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

// [START appengine_v1_generated_Applications_UpdateApplication_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppEngine\V1\Application;
use Google\Cloud\AppEngine\V1\ApplicationsClient;
use Google\Rpc\Status;

/**
 * Updates the specified Application resource.
 * You can update the following fields:
 *
 * * `auth_domain` - Google authentication domain for controlling user access to the application.
 * * `default_cookie_expiration` - Cookie expiration policy for the application.
 * * `iap` - Identity-Aware Proxy properties for the application.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_application_sample(): void
{
    // Create a client.
    $applicationsClient = new ApplicationsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $applicationsClient->updateApplication();
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
// [END appengine_v1_generated_Applications_UpdateApplication_sync]
