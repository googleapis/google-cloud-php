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

// [START retail_v2_generated_GenerativeQuestionService_UpdateGenerativeQuestionsFeatureConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Client\GenerativeQuestionServiceClient;
use Google\Cloud\Retail\V2\GenerativeQuestionsFeatureConfig;
use Google\Cloud\Retail\V2\UpdateGenerativeQuestionsFeatureConfigRequest;

/**
 * Manages overal generative question feature state -- enables toggling
 * feature on and off.
 *
 * @param string $generativeQuestionsFeatureConfigCatalog Resource name of the affected catalog.
 *                                                        Format: projects/{project}/locations/{location}/catalogs/{catalog}
 */
function update_generative_questions_feature_config_sample(
    string $generativeQuestionsFeatureConfigCatalog
): void {
    // Create a client.
    $generativeQuestionServiceClient = new GenerativeQuestionServiceClient();

    // Prepare the request message.
    $generativeQuestionsFeatureConfig = (new GenerativeQuestionsFeatureConfig())
        ->setCatalog($generativeQuestionsFeatureConfigCatalog);
    $request = (new UpdateGenerativeQuestionsFeatureConfigRequest())
        ->setGenerativeQuestionsFeatureConfig($generativeQuestionsFeatureConfig);

    // Call the API and handle any network failures.
    try {
        /** @var GenerativeQuestionsFeatureConfig $response */
        $response = $generativeQuestionServiceClient->updateGenerativeQuestionsFeatureConfig($request);
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
    $generativeQuestionsFeatureConfigCatalog = '[CATALOG]';

    update_generative_questions_feature_config_sample($generativeQuestionsFeatureConfigCatalog);
}
// [END retail_v2_generated_GenerativeQuestionService_UpdateGenerativeQuestionsFeatureConfig_sync]
