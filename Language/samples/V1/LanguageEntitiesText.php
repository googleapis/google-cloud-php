<?php
/*
 * Copyright 2019 Google LLC
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
 * DO NOT EDIT! This is a generated sample ("Request",  "language_entities_text")
 */

// sample-metadata
//   title: Analyzing Entities
//   description: Analyzing Entities in a String
//   usage: php samples/V1/LanguageEntitiesText.php [--text_content "California is a state."]
// [START language_entities_text]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;
use Google\Cloud\Language\V1\EncodingType;

/**
 * Analyzing Entities in a String.
 *
 * @param string $textContent The text content to analyze
 */
function sampleAnalyzeEntities($textContent)
{
    $languageServiceClient = new LanguageServiceClient();

    // $textContent = 'California is a state.';

    // Available types: PLAIN_TEXT, HTML
    $type = Type::PLAIN_TEXT;

    // Optional. If not specified, the language is automatically detected.
    // For list of supported languages:
    // https://cloud.google.com/natural-language/docs/languages
    $language = 'en';
    $document = new Document();
    $document->setContent($textContent);
    $document->setType($type);
    $document->setLanguage($language);

    // Available values: NONE, UTF8, UTF16, UTF32
    $encodingType = EncodingType::UTF8;

    try {
        $response = $languageServiceClient->analyzeEntities($document, ['encodingType' => $encodingType]);
        // Loop through entitites returned from the API
        foreach ($response->getEntities() as $entity) {
            printf('Representative name for the entity: %s'.PHP_EOL, $entity->getName());
            // Get entity type, e.g. PERSON, LOCATION, ADDRESS, NUMBER, et al
            printf('Entity type: %s'.PHP_EOL, \Google\Cloud\Language\V1\Entity\Type::name($entity->getType()));
            // Get the salience score associated with the entity in the [0, 1.0] range
            printf('Salience score: %s'.PHP_EOL, $entity->getSalience());
            // Loop over the metadata associated with entity. For many known entities,
            // the metadata is a Wikipedia URL (wikipedia_url) and Knowledge Graph MID (mid).
            // Some entity types may have additional metadata, e.g. ADDRESS entities
            // may have metadata for the address street_name, postal_code, et al.
            foreach ($entity->getMetadata() as $metadataName => $metadataValue) {
                printf('%s: %s'.PHP_EOL, $metadataName, $metadataValue);
            }

            // Loop over the mentions of this entity in the input document.
            // The API currently supports proper noun mentions.
            foreach ($entity->getMentions() as $mention) {
                printf('Mention text: %s'.PHP_EOL, $mention->getText()->getContent());
                // Get the mention type, e.g. PROPER for proper noun
                printf('Mention type: %s'.PHP_EOL, \Google\Cloud\Language\V1\EntityMention\Type::name($mention->getType()));
            }
        }
        // Get the language of the text, which will be the same as
        // the language specified in the request or, if not specified,
        // the automatically-detected language.
        printf('Language of the text: %s'.PHP_EOL, $response->getLanguage());
    } finally {
        $languageServiceClient->close();
    }
}
// [END language_entities_text]

$opts = [
    'text_content::',
];

$defaultOptions = [
    'text_content' => 'California is a state.',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$textContent = $options['text_content'];

sampleAnalyzeEntities($textContent);
