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

// [START aiplatform_v1_generated_ModelService_MergeVersionAliases_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Model;
use Google\Cloud\AIPlatform\V1\ModelServiceClient;

/**
 * Merges a set of aliases for a Model version.
 *
 * @param string $formattedName         The name of the model version to merge aliases, with a version ID
 *                                      explicitly included.
 *
 *                                      Example: `projects/{project}/locations/{location}/models/{model}&#64;1234`
 *                                      Please see {@see ModelServiceClient::modelName()} for help formatting this field.
 * @param string $versionAliasesElement The set of version aliases to merge.
 *                                      The alias should be at most 128 characters, and match
 *                                      `[a-z][a-zA-Z0-9-]{0,126}[a-z-0-9]`.
 *                                      Add the `-` prefix to an alias means removing that alias from the version.
 *                                      `-` is NOT counted in the 128 characters. Example: `-golden` means removing
 *                                      the `golden` alias from the version.
 *
 *                                      There is NO ordering in aliases, which means
 *                                      1) The aliases returned from GetModel API might not have the exactly same
 *                                      order from this MergeVersionAliases API. 2) Adding and deleting the same
 *                                      alias in the request is not recommended, and the 2 operations will be
 *                                      cancelled out.
 */
function merge_version_aliases_sample(string $formattedName, string $versionAliasesElement): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $versionAliases = [$versionAliasesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var Model $response */
        $response = $modelServiceClient->mergeVersionAliases($formattedName, $versionAliases);
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
    $formattedName = ModelServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');
    $versionAliasesElement = '[VERSION_ALIASES]';

    merge_version_aliases_sample($formattedName, $versionAliasesElement);
}
// [END aiplatform_v1_generated_ModelService_MergeVersionAliases_sync]
