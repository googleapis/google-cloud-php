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
 * DO NOT EDIT! This is a generated sample ("Request",  "language_sentiment_text")
 */

// sample-metadata
//   title: Analyzing Sentiment
//   description: Analyzing Sentiment in a String
//   usage: php samples/V1/LanguageSentimentText.php [--text_content "I am so happy and joyful."]
// [START language_sentiment_text]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;
use Google\Cloud\Language\V1\EncodingType;

/**
 * Analyzing Sentiment in a String.
 *
 * @param string $textContent The text content to analyze
 */
function sampleAnalyzeSentiment($textContent)
{
    $languageServiceClient = new LanguageServiceClient();

    // $textContent = 'I am so happy and joyful.';

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
        $response = $languageServiceClient->analyzeSentiment($document, ['encodingType' => $encodingType]);
        // Get overall sentiment of the input document
        printf('Document sentiment score: %s'.PHP_EOL, $response->getDocumentSentiment()->getScore());
        printf('Document sentiment magnitude: %s'.PHP_EOL, $response->getDocumentSentiment()->getMagnitude());
        // Get sentiment for all sentences in the document
        foreach ($response->getSentences() as $sentence) {
            printf('Sentence text: %s'.PHP_EOL, $sentence->getText()->getContent());
            printf('Sentence sentiment score: %s'.PHP_EOL, $sentence->getSentiment()->getScore());
            printf('Sentence sentiment magnitude: %s'.PHP_EOL, $sentence->getSentiment()->getMagnitude());
        }
        // Get the language of the text, which will be the same as
        // the language specified in the request or, if not specified,
        // the automatically-detected language.
        printf('Language of the text: %s'.PHP_EOL, $response->getLanguage());
    } finally {
        $languageServiceClient->close();
    }
}
// [END language_sentiment_text]

$opts = [
    'text_content::',
];

$defaultOptions = [
    'text_content' => 'I am so happy and joyful.',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$textContent = $options['text_content'];

sampleAnalyzeSentiment($textContent);
