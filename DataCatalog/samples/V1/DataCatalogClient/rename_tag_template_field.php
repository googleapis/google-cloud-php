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

// [START datacatalog_v1_generated_DataCatalog_RenameTagTemplateField_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\TagTemplateField;

/**
 * Renames a field in a tag template.
 *
 * You must enable the Data Catalog API in the project identified by the
 * `name` parameter. For more information, see [Data Catalog resource project]
 * (https://cloud.google.com/data-catalog/docs/concepts/resource-project).
 *
 * @param string $formattedName         The name of the tag template field. Please see
 *                                      {@see DataCatalogClient::tagTemplateFieldName()} for help formatting this field.
 * @param string $newTagTemplateFieldId The new ID of this tag template field. For example, `my_new_field`.
 */
function rename_tag_template_field_sample(
    string $formattedName,
    string $newTagTemplateFieldId
): void {
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Call the API and handle any network failures.
    try {
        /** @var TagTemplateField $response */
        $response = $dataCatalogClient->renameTagTemplateField($formattedName, $newTagTemplateFieldId);
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
    $formattedName = DataCatalogClient::tagTemplateFieldName(
        '[PROJECT]',
        '[LOCATION]',
        '[TAG_TEMPLATE]',
        '[FIELD]'
    );
    $newTagTemplateFieldId = '[NEW_TAG_TEMPLATE_FIELD_ID]';

    rename_tag_template_field_sample($formattedName, $newTagTemplateFieldId);
}
// [END datacatalog_v1_generated_DataCatalog_RenameTagTemplateField_sync]
