<?php
/*
 * Copyright 2024 Google LLC
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

// [START dataproc_v1_generated_SessionTemplateController_CreateSessionTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\Client\SessionTemplateControllerClient;
use Google\Cloud\Dataproc\V1\CreateSessionTemplateRequest;
use Google\Cloud\Dataproc\V1\SessionTemplate;

/**
 * Create a session template synchronously.
 *
 * @param string $formattedParent     The parent resource where this session template will be created. Please see
 *                                    {@see SessionTemplateControllerClient::locationName()} for help formatting this field.
 * @param string $sessionTemplateName The resource name of the session template.
 */
function create_session_template_sample(
    string $formattedParent,
    string $sessionTemplateName
): void {
    // Create a client.
    $sessionTemplateControllerClient = new SessionTemplateControllerClient();

    // Prepare the request message.
    $sessionTemplate = (new SessionTemplate())
        ->setName($sessionTemplateName);
    $request = (new CreateSessionTemplateRequest())
        ->setParent($formattedParent)
        ->setSessionTemplate($sessionTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var SessionTemplate $response */
        $response = $sessionTemplateControllerClient->createSessionTemplate($request);
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
    $formattedParent = SessionTemplateControllerClient::locationName('[PROJECT]', '[LOCATION]');
    $sessionTemplateName = '[NAME]';

    create_session_template_sample($formattedParent, $sessionTemplateName);
}
// [END dataproc_v1_generated_SessionTemplateController_CreateSessionTemplate_sync]
