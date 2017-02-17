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

namespace Google\Cloud\NaturalLanguage;

use Google\Cloud\ClientTrait;
use Google\Cloud\NaturalLanguage\Connection\ConnectionInterface;
use Google\Cloud\NaturalLanguage\Connection\Rest;
use Google\Cloud\Storage\StorageObject;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Google Cloud Natural Language client. Provides natural language understanding
 * technologies to developers, including sentiment analysis, entity recognition,
 * and syntax analysis. Currently only English, Spanish, and Japanese textual
 * context are supported. Find more information at
 * [Google Cloud Natural Language docs](https://cloud.google.com/natural-language/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 *
 * $language = $cloud->naturalLanguage();
 * ```
 *
 * ```
 * // NaturalLanguage can be instantiated directly.
 * use Google\Cloud\NaturalLanguage\NaturalLanguageClient;
 *
 * $language = new NaturalLanguageClient();
 * ```
 */
class NaturalLanguageClient
{
    use ClientTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var array
     */
    private $featureShortNames = [
        'syntax'    => 'extractSyntax',
        'entities'  => 'extractEntities',
        'sentiment' => 'extractDocumentSentiment'
    ];

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Create a NaturalLanguage client.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Finds named entities (currently finds proper names) in the text, entity
     * types, salience, mentions for each entity, and other properties in the
     * document.
     *
     * Example:
     * ```
     * $annotation = $language->analyzeEntities('Google Cloud Platform is a powerful tool.');
     *
     * foreach ($annotation->entities() as $entity) {
     *     echo $entity['type'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/reference/rest/v1beta1/documents/analyzeEntities Analyze Entities API documentation
     * @codingStandardsIgnoreEnd
     *
     * @param string|StorageObject $content The content to analyze.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $type The document type. Acceptable values are
     *           `PLAIN_TEXT` or `HTML`. **Defaults to** `"PLAIN_TEXT"`.
     *     @type string $language The language of the document. Both ISO
     *           (e.g., en, es) and BCP-47 (e.g., en-US, es-ES) language codes
     *           are accepted. If no value is provided, the language will be
     *           detected by the service.
     *     @type string $encodingType The text encoding type used by the API to
     *           calculate offsets. Acceptable values are `"NONE"`, `"UTF8"`,
     *           `"UTF16"` and `"UTF32"`. **Defaults to** `"UTF8"`.
     * }
     * @return Annotation
     */
    public function analyzeEntities($content, array $options = [])
    {
        return new Annotation(
            $this->connection->analyzeEntities(
                $this->formatRequest($content, $options)
            )
        );
    }

    /**
     * Analyzes the sentiment of the provided document.
     *
     * Example:
     * ```
     * $annotation = $language->analyzeSentiment('Google Cloud Platform is a powerful tool.');
     * $sentiment = $annotation->sentiment();
     *
     * if ($sentiment['score'] > 0) {
     *     echo 'This is a positive message.';
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/reference/rest/v1beta1/documents/analyzeSentiment Analyze Sentiment API documentation
     * @codingStandardsIgnoreEnd
     *
     * @param string|StorageObject $content The content to analyze.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $type The document type. Acceptable values are
     *           `PLAIN_TEXT` or `HTML`. **Defaults to** `"PLAIN_TEXT"`.
     *     @type string $language The language of the document. Both ISO
     *           (e.g., en, es) and BCP-47 (e.g., en-US, es-ES) language codes
     *           are accepted. If no value is provided, the language will be
     *           detected by the service.
     *     @type string $encodingType The text encoding type used by the API to
     *           calculate offsets. Acceptable values are `"NONE"`, `"UTF8"`,
     *           `"UTF16"` and `"UTF32"`. **Defaults to** `"UTF8"`.
     * }
     * @return Annotation
     */
    public function analyzeSentiment($content, array $options = [])
    {
        return new Annotation(
            $this->connection->analyzeSentiment(
                $this->formatRequest($content, $options)
            )
        );
    }

    /**
     * Analyzes the document and provides a full set of text annotations.
     *
     * Example:
     * ```
     * $annotation = $language->analyzeSyntax('Google Cloud Platform is a powerful tool.');
     *
     * foreach ($annotation->sentences() as $sentence) {
     *     echo $sentence['text']['beginOffset'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/reference/rest/v1beta1/documents/analyzeSyntax Analyze Syntax API documentation
     * @codingStandardsIgnoreEnd
     *
     * @param string|StorageObject $content The content to analyze.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $type The document type. Acceptable values are
     *           `PLAIN_TEXT` or `HTML`. **Defaults to** `"PLAIN_TEXT"`.
     *     @type string $language The language of the document. Both ISO
     *           (e.g., en, es) and BCP-47 (e.g., en-US, es-ES) language codes
     *           are accepted. If no value is provided, the language will be
     *           detected by the service.
     *     @type string $encodingType The text encoding type used by the API to
     *           calculate offsets. Acceptable values are `"NONE"`, `"UTF8"`,
     *           `"UTF16"` and `"UTF32"`. **Defaults to**  `"UTF8"`.
     * }
     * @return Annotation
     */
    public function analyzeSyntax($content, array $options = [])
    {
        $syntaxResponse = $this->connection->analyzeSyntax(
            $this->formatRequest($content, $options)
        );

        return new Annotation($syntaxResponse + ['entities' => []]);
    }

    /**
     * Analyzes the document and provides a full set of text annotations,
     * including semantic, syntactic, and sentiment information.
     *
     * Example:
     * ```
     * // Annotate text with all features enabled.
     * $annotation = $language->annotateText('Google Cloud Platform is a powerful tool.');
     * $sentiment = $annotation->sentiment();
     *
     * echo $sentiment['magnitude'];
     * ```
     *
     * ```
     * // Annotate text with syntax and sentiment features enabled.
     * $annotation = $language->annotateText('Google Cloud Platform is a powerful tool.', [
     *     'features' => ['syntax', 'sentiment']
     * ]);
     *
     * foreach ($annotation->tokens() as $token) {
     *     echo $token['text']['beginOffset'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/reference/rest/v1beta1/documents/annotateText Annotate Text API documentation
     * @codingStandardsIgnoreEnd
     *
     * @param string|StorageObject $content The content to annotate.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $features Features to apply to the request. Valid values
     *           are `syntax`, `sentiment`, and `entities`. If no features are
     *           provided the request will run with all three enabled.
     *     @type string $type The document type. Acceptable values are
     *           `PLAIN_TEXT` or `HTML`. **Defaults to** `"PLAIN_TEXT"`.
     *     @type string $language The language of the document. Both ISO
     *           (e.g., en, es) and BCP-47 (e.g., en-US, es-ES) language codes
     *           are accepted. If no value is provided, the language will be
     *           detected by the service.
     *     @type string $encodingType The text encoding type used by the API to
     *           calculate offsets. Acceptable values are `"NONE"`, `"UTF8"`,
     *           `"UTF16"` and `"UTF32"`. **Defaults to** `"UTF8"`.
     * }
     * @return Annotation
     */
    public function annotateText($content, array $options = [])
    {
        $features = isset($options['features'])
            ? $options['features']
            : array_values($this->featureShortNames);
        $options['features'] = $this->normalizeFeatures($features);

        return new Annotation(
            $this->connection->annotateText(
                $this->formatRequest($content, $options)
            )
        );
    }

    /**
     * Configures features in a way the API expects.
     *
     * @param array $features An array of features to normalize.
     * @return array
     */
    private function normalizeFeatures(array $features)
    {
        $results = [];

        foreach ($features as $feature) {
            $featureName = array_key_exists($feature, $this->featureShortNames)
                ? $this->featureShortNames[$feature]
                : $feature;

            $results[$featureName] = true;
        }

        return $results;
    }

    /**
     * Formats the request for the API.
     *
     * @param string|StorageObject $content The content to analyze.
     * @param array $options [optional] Configuration Options.
     * @return array
     */
    private function formatRequest($content, array $options)
    {
        $docOptions = ['type', 'language', 'content', 'gcsContentUri'];
        $options += [
            'encodingType' => 'UTF8',
            'type' => 'PLAIN_TEXT'
        ];

        if ($content instanceof StorageObject) {
            $objIdentity = $content->identity();
            $options['gcsContentUri'] = 'gs://' . $objIdentity['bucket'] . '/' . $objIdentity['object'];
        } else {
            $options['content'] = $content;
        }

        foreach ($options as $option => $value) {
            if (in_array($option, $docOptions)) {
                $options['document'][$option] = $value;
                unset($options[$option]);
            }
        }

        return $options;
    }
}
