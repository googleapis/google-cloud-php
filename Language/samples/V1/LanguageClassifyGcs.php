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
 * DO NOT EDIT! This is a generated sample ("Request",  "language_classify_gcs")
 */

// sample-metadata
//   title: Classify Content (GCS)
//   description: Classifying Content in text file stored in Cloud Storage
//   usage: php samples/V1/LanguageClassifyGcs.php [--gcs_content_uri "gs://cloud-samples-data/language/classify-entertainment.txt"]
// [START language_classify_gcs]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;

/**
 * Classifying Content in text file stored in Cloud Storage.
 *
 * @param string $gcsContentUri Google Cloud Storage URI where the file content is located.
 *                              e.g. gs://[Your Bucket]/[Path to File]
 *                              The text file must include at least 20 words.
 */
function sampleClassifyText($gcsContentUri)
{
    $languageServiceClient = new LanguageServiceClient();

    // $gcsContentUri = 'gs://cloud-samples-data/language/classify-entertainment.txt';

    // Available types: PLAIN_TEXT, HTML
    $type = Type::PLAIN_TEXT;

    // Optional. If not specified, the language is automatically detected.
    // For list of supported languages:
    // https://cloud.google.com/natural-language/docs/languages
    $language = 'en';
    $document = new Document();
    $document->setGcsContentUri($gcsContentUri);
    $document->setType($type);
    $document->setLanguage($language);

    try {
        $response = $languageServiceClient->classifyText($document);
        // Loop through classified categories returned from the API
        foreach ($response->getCategories() as $category) {
            // Get the name of the category representing the document.
            // See the predefined taxonomy of categories:
            // https://cloud.google.com/natural-language/docs/categories
            printf('Category name: %s'.PHP_EOL, $category->getName());
            // Get the confidence. Number representing how certain the classifier
            // is that this category represents the provided text.
            printf('Confidence: %s'.PHP_EOL, $category->getConfidence());
        }
    } finally {
        $languageServiceClient->close();
    }
}
// [END language_classify_gcs]

$opts = [
    'gcs_content_uri::',
];

$defaultOptions = [
    'gcs_content_uri' => 'gs://cloud-samples-data/language/classify-entertainment.txt',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$gcsContentUri = $options['gcs_content_uri'];

sampleClassifyText($gcsContentUri);
