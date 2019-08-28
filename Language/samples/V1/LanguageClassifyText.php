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
 * DO NOT EDIT! This is a generated sample ("Request",  "language_classify_text")
 */

// sample-metadata
//   title: Classify Content
//   description: Classifying Content in a String
//   usage: php samples/V1/LanguageClassifyText.php [--text_content "That actor on TV makes movies in Hollywood and also stars in a variety of popular new TV shows."]
// [START language_classify_text]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;

/**
 * Classifying Content in a String.
 *
 * @param string $textContent The text content to analyze. Must include at least 20 words.
 */
function sampleClassifyText($textContent)
{
    $languageServiceClient = new LanguageServiceClient();

    // $textContent = 'That actor on TV makes movies in Hollywood and also stars in a variety of popular new TV shows.';

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
// [END language_classify_text]

$opts = [
    'text_content::',
];

$defaultOptions = [
    'text_content' => 'That actor on TV makes movies in Hollywood and also stars in a variety of popular new TV shows.',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$textContent = $options['text_content'];

sampleClassifyText($textContent);
