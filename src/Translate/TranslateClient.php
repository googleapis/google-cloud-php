<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Translate;

use Google\Cloud\ClientTrait;
use Google\Cloud\Translate\Connection\ConnectionInterface;
use Google\Cloud\Translate\Connection\Rest;

/**
 * Google Translate client. Provides the ability to dynamically translate text
 * between thousands of language pairs. The Google Translate API lets websites
 * and programs integrate with Google Translate API programmatically. Google
 * Translate API is available as a paid service. See the
 * [Pricing](https://cloud.google.com/translate/v2/pricing) and
 * [FAQ](https://cloud.google.com/translate/v2/faq) pages for details. Find more
 * information at
 * [Google Translate docs](https://cloud.google.com/translate/docs/).
 *
 * Please note that unlike most other Cloud Platform services Google Translate
 * requires a public API access key and cannot currently be accessed with a
 * service account or application default credentials. Follow the
 * [before you begin](https://cloud.google.com/translate/v2/translating-text-with-rest#before-you-begin)
 * instructions to learn how to generate a key.
 */
class TranslateClient
{
    use ClientTrait;

    const ENGLISH_LANGUAGE_CODE = 'en';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $targetLanguage;

    /**
     * Create a Translate client.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder([
     *     'key' => 'YOUR_KEY'
     * ]);
     *
     * $translate = $cloud->translate();
     * ```
     *
     * ```
     * // The Translate client can also be instantianted directly.
     * use Google\Cloud\Translate\TranslateClient;
     *
     * $translate = new TranslateClient([
     *     'key' => 'YOUR_KEY'
     * ]);
     * ```
     *
     * @param array $config {
     *     Configuration Options.
     *
     *     @type string $key A public API access key.
     *     @type string $target The target language to assign to the client.
     *           Must be a valid ISO 639-1 language code. Defaults to `en`
     *           (English).
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['key'])) {
            throw new \InvalidArgumentException('A key is required.');
        }

        $this->key = $config['key'];
        $this->targetLanguage = isset($config['target'])
            ? $config['target']
            : self::ENGLISH_LANGUAGE_CODE;

        unset($config['key']);
        unset($config['target']);

        $this->connection = new Rest($config + [
            'shouldSignRequest' => false
        ]);
    }

    /**
     * Translate a string from one language to another.
     *
     * Example:
     * ```
     * $translation = $translate->translate('Hello world!');
     *
     * echo $translation['text'];
     * ```
     *
     * @see https://cloud.google.com/translate/v2/translating-text-with-rest Translating Text
     *
     * @param string $string The string to translate.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $source The source language to translate from. Must be a
     *           valid ISO 639-1 language code. If not provided the value will
     *           be automatically detected by the server.
     *     @type string $target The target language to translate to. Must be a
     *           valid ISO 639-1 language code. Defaults to the value assigned
     *           to the client (`en` by default).
     *     @type string $format Indicates whether the string to be translated is
     *           either plain-text or HTML. Acceptable values are `html` or
     *          `text`. Defaults to `html`.
     * }
     * @return array A translation result including a `source` key containing
     *         the detected or provided langauge of the provided input, an
     *         `input` key containing the original string, and a `text` key
     *         containing the translated result.
     */
    public function translate($string, array $options = [])
    {
        return $this->translateBatch([$string], $options)[0];
    }

    /**
     * Translate multiple strings from one language to another.
     *
     * Example:
     * ```
     * $translations = $translate->translateBatch([
     *     'Hello world!',
     *     'My name is David.'
     * ]);
     *
     * foreach ($translations as $translation) {
     *     echo $translation['text'];
     * }
     * ```
     *
     * @see https://cloud.google.com/translate/v2/translating-text-with-rest Translating Text
     *
     * @param array $strings An array of strings to translate.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $source The source language to translate from. Must be a
     *           valid ISO 639-1 language code. If not provided the value will
     *           be automatically detected by the server.
     *     @type string $target The target language to translate to. Must be a
     *           valid ISO 639-1 language code. Defaults to the value assigned
     *           to the client (`en` by default).
     *     @type string $format Indicates whether the string to be translated is
     *           either plain-text or HTML. Acceptable values are `html` or
     *          `text`. Defaults to `html`.
     * }
     * @return array A set of translation results. Each result includes a
     *         `source` key containing the detected or provided language of the
     *         provided input, an `input` key containing the original string,
     *         and a `text` key containing the translated result.
     */
    public function translateBatch($strings, array $options = [])
    {
        $response = $this->connection->listTranslations($options + [
            'q' => $strings,
            'key' => $this->key,
            'target' => $this->targetLanguage
        ]);

        $translations = [];

        foreach ($response['data']['translations'] as $key => $translation) {
            $source = isset($translation['detectedSourceLanguage'])
                ? $translation['detectedSourceLanguage']
                : $options['source'];

            $translations[] = [
                'source' => $source,
                'input' => $strings[$key],
                'text' => $translation['translatedText']
            ];
        }

        return $translations;
    }

    /**
     * Detect the language of a string.
     *
     * Example:
     * ```
     * $result = $translate->detectLanguage('Hello world!');
     *
     * echo $result['languageCode'];
     * ```
     *
     * @see https://cloud.google.com/translate/v2/detecting-language-with-rest Detecting Langauge
     *
     * @param string $string The string to detect the language of.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $format Indicates whether the string to be translated is
     *           either plain-text or HTML. Acceptable values are `html` or
     *          `text`. Defaults to `html`.
     * }
     * @return array A result including a `languagecode` key
     *         containing the detected ISO 639-1 language code, an `input` key
     *         containing the original string, and in most cases a `confidence`
     *         key containing a value between 0 - 1 signifying the confidence of
     *         the result.
     */
    public function detectLanguage($string, array $options = [])
    {
        return $this->detectLanguageBatch([$string], $options)[0];
    }

    /**
     * Detect the language of multiple strings.
     *
     * Example:
     * ```
     * $results = $translate->detectLanguageBatch([
     *     'Hello World!',
     *     'My name is David.'
     * ]);
     *
     * foreach ($results as $result) {
     *     echo $result['languageCode'];
     * }
     * ```
     *
     * @see https://cloud.google.com/translate/v2/detecting-language-with-rest Detecting Langauge
     *
     * @param string $string The string to detect the language of.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $format Indicates whether the string to be translated is
     *           either plain-text or HTML. Acceptable values are `html` or
     *          `text`. Defaults to `html`.
     * }
     * @return array A set of results. Each result includes a `languageCode` key
     *         containing the detected ISO 639-1 language code, an `input` key
     *         containing the original string, and in most cases a `confidence`
     *         key containing a value between 0 - 1 signifying the confidence of
     *         the result.
     */
    public function detectLanguageBatch($strings, array $options = [])
    {
        $response =  $this->connection->listDetections($options + [
            'q' => $strings,
            'key' => $this->key
        ]);

        $detections = [];

        foreach ($response['data']['detections'] as $key => $detection) {
            $detection = $detection[0];

            $detections[] = array_filter([
                'languageCode' => $detection['language'],
                'input' => $strings[$key],
                'confidence' => isset($detection['confidence']) ? $detection['confidence'] : null
            ]);
        }

        return $detections;
    }

    /**
     * Get all supported languages.
     *
     * Example:
     * ```
     * $languages = $translate->languages();
     *
     * foreach ($languages as $language) {
     *     echo $language;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/translate/v2/discovering-supported-languages-with-rest Discovering Supported Languages
     * @codingStandardsIgnoreEnd
     *
     * @param array $options Configuration options.
     * @return array A list of supported ISO 639-1 language codes.
     */
    public function languages(array $options = [])
    {
        $response = $this->localizedLanguages($options + ['target' => null]);

        return array_map(function ($language) {
            return $language['code'];
        }, $response);
    }

    /**
     * Get the supported languages for translation in the targeted language.
     *
     * Unlike {@see Google\Cloud\Translate\TranslateClient::languages()} this
     * will return the localized language names in addition to the ISO 639-1
     * language codes.
     *
     * Example:
     * ```
     * $languages = $translate->localizedLanguages();
     *
     * foreach ($languages as $language) {
     *     echo $language['code'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/translate/v2/discovering-supported-languages-with-rest Discovering Supported Languages
     * @codingStandardsIgnoreEnd
     *
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $target The language to discover supported languages
     *           for. Must be a valid ISO 639-1 language code. Defaults to the
     *           value assigned to the client (`en` by default).
     * }
     * @return array A set of language results. Each result includes a `code`
     *         key containing the ISO 639-1 code for the supported language and
     *         a `name` key containing the name of the language written in the
     *         target language.
     */
    public function localizedLanguages(array $options = [])
    {
        $response = $this->connection->listLanguages($options + [
            'key' => $this->key,
            'target' => $this->targetLanguage
        ]);

        return array_map(function ($language) {
            return array_filter([
                'code' => $language['language'],
                'name' => isset($language['name']) ? $language['name'] : null
            ]);
        }, $response['data']['languages']);
    }
}
