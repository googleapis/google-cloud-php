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

// [START dialogflow_v3_generated_SessionEntityTypes_CreateSessionEntityType_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\SessionEntityTypesClient;
use Google\Cloud\Dialogflow\Cx\V3\CreateSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\Cx\V3\EntityType\Entity;
use Google\Cloud\Dialogflow\Cx\V3\SessionEntityType;
use Google\Cloud\Dialogflow\Cx\V3\SessionEntityType\EntityOverrideMode;

/**
 * Creates a session entity type.
 *
 * @param string $formattedParent                          The session to create a session entity type for.
 *                                                         Format:
 *                                                         `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/sessions/<SessionID>`
 *                                                         or
 *                                                         `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/environments/<EnvironmentID>/sessions/<SessionID>`.
 *                                                         If `Environment ID` is not specified, we assume default 'draft'
 *                                                         environment. Please see
 *                                                         {@see SessionEntityTypesClient::sessionName()} for help formatting this field.
 * @param string $sessionEntityTypeName                    The unique identifier of the session entity type.
 *                                                         Format:
 *                                                         `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/sessions/<SessionID>/entityTypes/<EntityTypeID>`
 *                                                         or
 *                                                         `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/environments/<EnvironmentID>/sessions/<SessionID>/entityTypes/<EntityTypeID>`.
 *                                                         If `Environment ID` is not specified, we assume default 'draft'
 *                                                         environment.
 * @param int    $sessionEntityTypeEntityOverrideMode      Indicates whether the additional data should override or
 *                                                         supplement the custom entity type definition.
 * @param string $sessionEntityTypeEntitiesValue           The primary value associated with this entity entry.
 *                                                         For example, if the entity type is *vegetable*, the value could be
 *                                                         *scallions*.
 *
 *                                                         For `KIND_MAP` entity types:
 *
 *                                                         *   A canonical value to be used in place of synonyms.
 *
 *                                                         For `KIND_LIST` entity types:
 *
 *                                                         *   A string that can contain references to other entity types (with or
 *                                                         without aliases).
 * @param string $sessionEntityTypeEntitiesSynonymsElement A collection of value synonyms. For example, if the entity type
 *                                                         is *vegetable*, and `value` is *scallions*, a synonym could be *green
 *                                                         onions*.
 *
 *                                                         For `KIND_LIST` entity types:
 *
 *                                                         *   This collection must contain exactly one synonym equal to `value`.
 */
function create_session_entity_type_sample(
    string $formattedParent,
    string $sessionEntityTypeName,
    int $sessionEntityTypeEntityOverrideMode,
    string $sessionEntityTypeEntitiesValue,
    string $sessionEntityTypeEntitiesSynonymsElement
): void {
    // Create a client.
    $sessionEntityTypesClient = new SessionEntityTypesClient();

    // Prepare the request message.
    $sessionEntityTypeEntitiesSynonyms = [$sessionEntityTypeEntitiesSynonymsElement,];
    $entity = (new Entity())
        ->setValue($sessionEntityTypeEntitiesValue)
        ->setSynonyms($sessionEntityTypeEntitiesSynonyms);
    $sessionEntityTypeEntities = [$entity,];
    $sessionEntityType = (new SessionEntityType())
        ->setName($sessionEntityTypeName)
        ->setEntityOverrideMode($sessionEntityTypeEntityOverrideMode)
        ->setEntities($sessionEntityTypeEntities);
    $request = (new CreateSessionEntityTypeRequest())
        ->setParent($formattedParent)
        ->setSessionEntityType($sessionEntityType);

    // Call the API and handle any network failures.
    try {
        /** @var SessionEntityType $response */
        $response = $sessionEntityTypesClient->createSessionEntityType($request);
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
    $formattedParent = SessionEntityTypesClient::sessionName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[SESSION]'
    );
    $sessionEntityTypeName = '[NAME]';
    $sessionEntityTypeEntityOverrideMode = EntityOverrideMode::ENTITY_OVERRIDE_MODE_UNSPECIFIED;
    $sessionEntityTypeEntitiesValue = '[VALUE]';
    $sessionEntityTypeEntitiesSynonymsElement = '[SYNONYMS]';

    create_session_entity_type_sample(
        $formattedParent,
        $sessionEntityTypeName,
        $sessionEntityTypeEntityOverrideMode,
        $sessionEntityTypeEntitiesValue,
        $sessionEntityTypeEntitiesSynonymsElement
    );
}
// [END dialogflow_v3_generated_SessionEntityTypes_CreateSessionEntityType_sync]
