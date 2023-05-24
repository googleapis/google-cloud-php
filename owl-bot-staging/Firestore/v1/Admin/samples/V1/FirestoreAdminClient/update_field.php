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

// [START firestore_v1_generated_FirestoreAdmin_UpdateField_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Firestore\Admin\V1\Field;
use Google\Cloud\Firestore\Admin\V1\FirestoreAdminClient;
use Google\Rpc\Status;

/**
 * Updates a field configuration. Currently, field updates apply only to
 * single field index configuration. However, calls to
 * [FirestoreAdmin.UpdateField][google.firestore.admin.v1.FirestoreAdmin.UpdateField] should provide a field mask to avoid
 * changing any configuration that the caller isn't aware of. The field mask
 * should be specified as: `{ paths: "index_config" }`.
 *
 * This call returns a [google.longrunning.Operation][google.longrunning.Operation] which may be used to
 * track the status of the field update. The metadata for
 * the operation will be the type [FieldOperationMetadata][google.firestore.admin.v1.FieldOperationMetadata].
 *
 * To configure the default field settings for the database, use
 * the special `Field` with resource name:
 * `projects/{project_id}/databases/{database_id}/collectionGroups/__default__/fields/*`.
 *
 * @param string $fieldName A field name of the form
 *                          `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}/fields/{field_path}`
 *
 *                          A field path may be a simple field name, e.g. `address` or a path to fields
 *                          within map_value , e.g. `address.city`,
 *                          or a special field path. The only valid special field is `*`, which
 *                          represents any field.
 *
 *                          Field paths may be quoted using ` (backtick). The only character that needs
 *                          to be escaped within a quoted field path is the backtick character itself,
 *                          escaped using a backslash. Special characters in field paths that
 *                          must be quoted include: `*`, `.`,
 *                          ``` (backtick), `[`, `]`, as well as any ascii symbolic characters.
 *
 *                          Examples:
 *                          (Note: Comments here are written in markdown syntax, so there is an
 *                          additional layer of backticks to represent a code block)
 *                          `\`address.city\`` represents a field named `address.city`, not the map key
 *                          `city` in the field `address`.
 *                          `\`*\`` represents a field named `*`, not any field.
 *
 *                          A special `Field` contains the default indexing settings for all fields.
 *                          This field's resource name is:
 *                          `projects/{project_id}/databases/{database_id}/collectionGroups/__default__/fields/*`
 *                          Indexes defined on this `Field` will be applied to all fields which do not
 *                          have their own `Field` index configuration.
 */
function update_field_sample(string $fieldName): void
{
    // Create a client.
    $firestoreAdminClient = new FirestoreAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $field = (new Field())
        ->setName($fieldName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $firestoreAdminClient->updateField($field);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Field $result */
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
    $fieldName = '[NAME]';

    update_field_sample($fieldName);
}
// [END firestore_v1_generated_FirestoreAdmin_UpdateField_sync]
