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
 * DO NOT EDIT! This is a generated sample ("Request",  "language_sentiment_gcs")
 */

// sample-metadata
//   title: Analyzing Sentiment (GCS)
//   description: Analyzing Sentiment in text file stored in Cloud Storage
//   usage: php samples/V1/LanguageSentimentGcs.php [--gcs_content_uri "gs://cloud-samples-data/language/sentiment-positive.txt"]
// [START language_sentiment_gcs]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;
use Google\Cloud\Language\V1\EncodingType;

/**
 * Analyzing Sentiment in text file stored in Cloud Storage.
 *
 * @param string $gcsContentUri Google Cloud Storage URI where the file content is located.
 *                              e.g. gs://[Your Bucket]/[Path to File]
 */
function sampleAnalyzeSentiment($gcsContentUri)
{
    $languageServiceClient = new LanguageServiceClient();

    // $gcsContentUri = 'gs://cloud-samples-data/language/sentiment-positive.txt';

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
// [END language_sentiment_gcs]

$opts = [
    'gcs_content_uri::',
];

$defaultOptions = [
    'gcs_content_uri' => 'gs://cloud-samples-data/language/sentiment-positive.txt',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$gcsContentUri = $options['gcs_content_uri'];

sampleAnalyzeSentiment($gcsContentUri);
