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

// [START cloudfunctions_v1_generated_CloudFunctionsService_GetIamPolicy_sync]
use Google\Cloud\Functions\V1\CloudFunctionsServiceClient;

$cloudFunctionsServiceClient = new CloudFunctionsServiceClient();
try {
    $resource = 'resource';
    $response = $cloudFunctionsServiceClient->getIamPolicy($resource);
} finally {
    $cloudFunctionsServiceClient->close();
}

// [END cloudfunctions_v1_generated_CloudFunctionsService_GetIamPolicy_sync]
