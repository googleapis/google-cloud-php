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

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Translate\Connection\ConnectionInterface;
use Google\Cloud\Translate\Connection\Rest;

/**
 * Google Cloud Translation provides the ability to dynamically translate
 * text between thousands of language pairs and lets websites and programs
 * integrate with translation service programmatically. Find more
 * information at the the
 * [Google Cloud Translation docs](https://cloud.google.com/translation/docs/).
 *
 * The Google Cloud Translation API is available as a paid
 * service. See the [Pricing](https://cloud.google.com/translation/v2/pricing)
 * and [FAQ](https://cloud.google.com/translation/v2/faq) pages for details.
 *
 * Please note that while the Google Cloud Translation API supports
 * authentication via service account and application default credentials
 * like other Cloud Platform APIs, it also supports authentication via a
 * public API access key. If you wish to authenticate using an API key,
 * follow the
 * [before you begin](https://cloud.google.com/translation/v2/translating-text-with-rest#before-you-begin)
 * instructions to learn how to generate a key.
 *
 * Example:
 * ```
 * use Google\Cloud\Translate\TranslateClient;
 *
 * $translate = new TranslateClient();
 * ```
 */
class TranslateClient
{
    use ClientTrait;

    const VERSION = '1.1.2';

    const ENGLISH_LANGUAGE_CODE = 'en';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $targetLanguage;

    /**
     * @var string
     */
    private $key;

    /**
     * Create a Translate client.
     *
     * Note that when creating a TranslateClient instance, setting
     * `$config.projectId` is not supported. To switch between projects, you
     * must provide credentials with access to the project.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $key A public API access key.
     *     @type string $target The target language to assign to the client.
     *           Must be a valid ISO 639-1 language code. **Defaults to** `"en"`
     *           (English).
     *     @type CacheItemPoolInterface $authCache A cache used storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $this->key = (isset($config['key']))
            ? $config['key']
            : null;

        $this->targetLanguage = isset($config['target'])
            ? $config['target']
            : self::ENGLISH_LANGUAGE_CODE;

        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        if (!$this->key) {
            $config = $this->configureAuthentication($config);
        } else {
            $config['shouldSignRequest'] = false;
        }

        unset($config['key']);
        unset($config['target']);

        $this->connection = new Rest($config);
    }

    /**
     * Translate a string from one language to another.
     *
     * Example:
     * ```
     * $result = $translate->translate('Hello world!');
     *
     * echo $result['text'];
     * ```
     *
     * @see https://cloud.google.com/translation/v2/translating-text-with-rest Translating Text
     *
     * @param string $string The string to translate.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $source The source language to translate from. Must be a
     *           valid ISO 639-1 language code. If not provided the value will
     *           be automatically detected by the server.
     *     @type string $target The target language to translate to. Must be a
     *           valid ISO 639-1 language code. **Defaults to** the value assigned
     *           to the client (`"en"` by default).
     *     @type string $format Indicates whether the string to be translated is
     *           either plain-text or HTML. Acceptable values are `html` or
     *           `text`. **Defaults to** `"html"`.
     *     @type string $model The model to use for the translation request. May
     *           be `nmt` (for the NMT model) or `base` (for the PBMT model).
     *           **Defaults to** using the NMT model. If the NMT model is not
     *           supported for the requested language translation pair, the PBMT
     *           model will be defaulted instead. For a list of supported
     *           languages for the model types, please see the
     *           [Language Support](https://cloud.google.com/translate/docs/languages)
     *           documentation.
     * }
     * @return array|null A translation result including a `source` key containing
     *         the detected or provided language of the provided input, an
     *         `input` key containing the original string, and a `text` key
     *         containing the translated result.
     */
    public function translate($string, array $options = [])
    {
        $res = $this->translateBatch([$string], $options);
        if (count($res) > 0) {
            return $res[0];
        }
    }

    /**
     * Translate multiple strings from one language to another.
     *
     * Example:
     * ```
     * $results = $translate->translateBatch([
     *     'Hello world!',
     *     'My name is David.'
     * ]);
     *
     * foreach ($results as $result) {
     *     echo $result['text'];
     * }
     * ```
     *
     * @see https://cloud.google.com/translation/v2/translating-text-with-rest Translating Text
     *
     * @param array $strings An array of strings to translate.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $source The source language to translate from. Must be a
     *           valid ISO 639-1 language code. If not provided the value will
     *           be automatically detected by the server.
     *     @type string $target The target language to translate to. Must be a
     *           valid ISO 639-1 language code. **Defaults to** the value assigned
     *           to the client (`"en"` by default).
     *     @type string $format Indicates whether the string to be translated is
     *           either plain-text or HTML. Acceptable values are `html` or
     *           `text`. **Defaults to** `"html"`.
     *     @type string $model The model to use for the translation request. May
     *           be `nmt` (for the NMT model) or `base` (for the PBMT model).
     *           **Defaults to** using the NMT model. If the NMT model is not
     *           supported for the requested language translation pair, the PBMT
     *           model will be defaulted instead. For a list of supported
     *           languages for the model types, please see the
     *           [Language Support](https://cloud.google.com/translate/docs/languages)
     *           documentation.
     * }
     * @return array A set of translation results. Each result includes a
     *         `source` key containing the detected or provided language of the
     *         provided input, an `input` key containing the original string,
     *         and a `text` key containing the translated result.
     */
    public function translateBatch(array $strings, array $options = [])
    {
        $options += [
            'model' => null,
        ];

        $options = array_filter($options + [
            'q' => $strings,
            'key' => $this->key,
            'target' => $this->targetLanguage,
            'model' => $options['model']
        ], function ($opt) {
            return !is_null($opt);
        });

        $response = $this->connection->listTranslations($options);

        $translations = [];
        $strings = array_values($strings);

        if (isset($response['data']['translations'])) {
            foreach ($response['data']['translations'] as $key => $translation) {
                $source = isset($translation['detectedSourceLanguage'])
                    ? $translation['detectedSourceLanguage']
                    : $options['source'];

                $model = (isset($translation['model']))
                    ? $translation['model']
                    : null;

                $translations[] = [
                    'source' => $source,
                    'input' => $strings[$key],
                    'text' => $translation['translatedText'],
                    'model' => $model
                ];
            }
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
     * @see https://cloud.google.com/translation/v2/detecting-language-with-rest Detecting Langauge
     *
     * @param string $string The string to detect the language of.
     * @param array $options [optional] Configuration Options.
     * @return array A result including a `languageCode` key
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
     * @see https://cloud.google.com/translation/v2/detecting-language-with-rest Detecting Langauge
     *
     * @param string $string The string to detect the language of.
     * @param array $options [optional] Configuration Options.
     * @return array A set of results. Each result includes a `languageCode` key
     *         containing the detected ISO 639-1 language code, an `input` key
     *         containing the original string, and in most cases a `confidence`
     *         key containing a value between 0 - 1 signifying the confidence of
     *         the result.
     */
    public function detectLanguageBatch(array $strings, array $options = [])
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
     * @see https://cloud.google.com/translation/v2/discovering-supported-languages-with-rest Discovering Supported Languages
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration Options.
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
     * @see https://cloud.google.com/translation/v2/discovering-supported-languages-with-rest Discovering Supported Languages
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $target The language to discover supported languages
     *           for. Must be a valid ISO 639-1 language code. **Defaults to** the
     *           value assigned to the client (`"en"` by default).
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
