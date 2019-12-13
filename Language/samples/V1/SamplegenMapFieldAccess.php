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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_map_field_access")
 */

// sample-metadata
//   title: This sample reads and loops over a map field in the response
//   description: This sample reads and loops over a map field in the response
//   usage: php samples/V1/SamplegenMapFieldAccess.php
// [START samplegen_map_field_access]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;

/** This sample reads and loops over a map field in the response */
function sampleAnalyzeEntities()
{
    $languageServiceClient = new LanguageServiceClient();

    $type = Type::PLAIN_TEXT;
    $language = 'en';

    // The text content to analyze
    $content = 'Googleplex is at 1600 Amphitheatre Parkway, Mountain View, CA.';
    $document = new Document();
    $document->setType($type);
    $document->setLanguage($language);
    $document->setContent($content);

    try {
        $response = $languageServiceClient->analyzeEntities($document);
        foreach ($response->getEntities() as $entity) {
            // Access value by key:
            printf('URL: %s'.PHP_EOL, $entity->getMetadata()['wikipedia_url']);
            // Loop over keys and values:
            foreach ($entity->getMetadata() as $key => $value) {
                printf('%s: %s'.PHP_EOL, $key, $value);
            }

            // Loop over just keys:
            foreach (array_keys($entity->getMetadata()) as $theKey) {
                printf('Key: %s'.PHP_EOL, $theKey);
            }

            // Loop over just values:
            foreach ($entity->getMetadata() as $theValue) {
                printf('Value: %s'.PHP_EOL, $theValue);
            }
        }
    } finally {
        $languageServiceClient->close();
    }
}
// [END samplegen_map_field_access]

sampleAnalyzeEntities();
