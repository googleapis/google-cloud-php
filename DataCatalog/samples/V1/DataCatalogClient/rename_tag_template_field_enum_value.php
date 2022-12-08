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

// [START datacatalog_v1_generated_DataCatalog_RenameTagTemplateFieldEnumValue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\TagTemplateField;

/**
 * Renames an enum value in a tag template.
 *
 * Within a single enum field, enum values must be unique.
 *
 * @param string $formattedName           The name of the enum field value. Please see
 *                                        {@see DataCatalogClient::tagTemplateFieldEnumValueName()} for help formatting this field.
 * @param string $newEnumValueDisplayName The new display name of the enum value. For example, `my_new_enum_value`.
 */
function rename_tag_template_field_enum_value_sample(
    string $formattedName,
    string $newEnumValueDisplayName
): void {
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Call the API and handle any network failures.
    try {
        /** @var TagTemplateField $response */
        $response = $dataCatalogClient->renameTagTemplateFieldEnumValue(
            $formattedName,
            $newEnumValueDisplayName
        );
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
    $formattedName = DataCatalogClient::tagTemplateFieldEnumValueName(
        '[PROJECT]',
        '[LOCATION]',
        '[TAG_TEMPLATE]',
        '[TAG_TEMPLATE_FIELD_ID]',
        '[ENUM_VALUE_DISPLAY_NAME]'
    );
    $newEnumValueDisplayName = '[NEW_ENUM_VALUE_DISPLAY_NAME]';

    rename_tag_template_field_enum_value_sample($formattedName, $newEnumValueDisplayName);
}
// [END datacatalog_v1_generated_DataCatalog_RenameTagTemplateFieldEnumValue_sync]
