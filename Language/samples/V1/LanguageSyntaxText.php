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
 * DO NOT EDIT! This is a generated sample ("Request",  "language_syntax_text")
 */

// sample-metadata
//   title: Analyzing Syntax
//   description: Analyzing Syntax in a String
//   usage: php samples/V1/LanguageSyntaxText.php [--text_content "This is a short sentence."]
// [START language_syntax_text]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\DependencyEdge\Label;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;
use Google\Cloud\Language\V1\EncodingType;
use Google\Cloud\Language\V1\PartOfSpeech\Tag;
use Google\Cloud\Language\V1\PartOfSpeech\Tense;
use Google\Cloud\Language\V1\PartOfSpeech\Voice;

/**
 * Analyzing Syntax in a String.
 *
 * @param string $textContent The text content to analyze
 */
function sampleAnalyzeSyntax($textContent)
{
    $languageServiceClient = new LanguageServiceClient();

    // $textContent = 'This is a short sentence.';

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
        $response = $languageServiceClient->analyzeSyntax($document, ['encodingType' => $encodingType]);
        // Loop through tokens returned from the API
        foreach ($response->getTokens() as $token) {
            // Get the text content of this token. Usually a word or punctuation.
            $text = $token->getText();
            printf('Token text: %s'.PHP_EOL, $text->getContent());
            printf('Location of this token in overall document: %s'.PHP_EOL, $text->getBeginOffset());
            // Get the part of speech information for this token.
            // Parts of spech are as defined in:
            // http://www.lrec-conf.org/proceedings/lrec2012/pdf/274_Paper.pdf
            $partOfSpeech = $token->getPartOfSpeech();
            // Get the tag, e.g. NOUN, ADJ for Adjective, et al.
            printf('Part of Speech tag: %s'.PHP_EOL, Tag::name($partOfSpeech->getTag()));
            // Get the voice, e.g. ACTIVE or PASSIVE
            printf('Voice: %s'.PHP_EOL, Voice::name($partOfSpeech->getVoice()));
            // Get the tense, e.g. PAST, FUTURE, PRESENT, et al.
            printf('Tense: %s'.PHP_EOL, Tense::name($partOfSpeech->getTense()));
            // See API reference for additional Part of Speech information available
            // Get the lemma of the token. Wikipedia lemma description
            // https://en.wikipedia.org/wiki/Lemma_(morphology)
            printf('Lemma: %s'.PHP_EOL, $token->getLemma());
            // Get the dependency tree parse information for this token.
            // For more information on dependency labels:
            // http://www.aclweb.org/anthology/P13-2017
            $dependencyEdge = $token->getDependencyEdge();
            printf('Head token index: %s'.PHP_EOL, $dependencyEdge->getHeadTokenIndex());
            printf('Label: %s'.PHP_EOL, Label::name($dependencyEdge->getLabel()));
        }
        // Get the language of the text, which will be the same as
        // the language specified in the request or, if not specified,
        // the automatically-detected language.
        printf('Language of the text: %s'.PHP_EOL, $response->getLanguage());
    } finally {
        $languageServiceClient->close();
    }
}
// [END language_syntax_text]

$opts = [
    'text_content::',
];

$defaultOptions = [
    'text_content' => 'This is a short sentence.',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$textContent = $options['text_content'];

sampleAnalyzeSyntax($textContent);
