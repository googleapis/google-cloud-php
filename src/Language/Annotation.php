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

namespace Google\Cloud\Language;

use Google\Cloud\Core\CallTrait;

/**
 * Annotations represent the result of a request against the
 * [Google Cloud Natural Language API](https://cloud.google.com/natural-language/docs).
 *
 * This class is created internally by
 * {@see Google\Cloud\Language\LanguageClient} and is used to
 * represent various document analyzation results. It should not be instantiated
 * externally.
 *
 * Annotations are returned by
 * {@see Google\Cloud\Language\LanguageClient::analyzeEntities()},
 * {@see Google\Cloud\Language\LanguageClient::analyzeSentiment()},
 * {@see Google\Cloud\Language\LanguageClient::analyzeSyntax()} and
 * {@see Google\Cloud\Language\LanguageClient::annotateText()}.
 *
 * Example:
 * ```
 * use Google\Cloud\Language\LanguageClient;
 *
 * $language = new LanguageClient();
 *
 * $annotation = $language->annotateText('Google Cloud Platform is a powerful tool.');
 * ```
 *
 * @method sentences() {
 *     Returns an array of sentences found in the document.
 *
 *     Example:
 *     ```
 *     foreach ($annotation->sentences() as $sentence) {
 *         echo $sentence['text']['content'];
 *     }
 *     ```
 *
 *     @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Sentence Sentence type documentation
 *
 *     @return array|null
 * }
 * @method tokens() {
 *     Returns an array of tokens found in the document.
 *
 *     Example:
 *     ```
 *     foreach ($annotation->tokens() as $token) {
 *         echo $token['text']['content'];
 *     }
 *     ```
 *
 *     @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Token Token type documentation
 *
 *     @return array|null
 * }
 * @method entities() {
 *     Returns an array of entities found in the document.
 *
 *     Example:
 *     ```
 *     foreach ($annotation->entities() as $entity) {
 *         echo $entity['type'];
 *     }
 *     ```
 *
 *     @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Entity Entity type documentation
 *
 *     @return array|null
 * }
 * @method language() {
 *     Returns the language of the document.
 *
 *     Example:
 *     ```
 *     echo $annotation->language();
 *     ```
 *
 *     @return string
 * }
 */
class Annotation
{
    use CallTrait;

    /**
     * @var array The annotation's metadata.
     */
    private $info;

    /**
     * Create an annotation.
     *
     * @param array $info [optional] The annotation's metadata.
     */
    public function __construct(array $info = [])
    {
        $this->info = $info;
    }

    /**
     * Returns the full response from the API.
     *
     * Example:
     * ```
     * $info = $annotation->info();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/documents/annotateText#response-body Annotate Text documentation
     * @codingStandardsIgnoreEnd
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Returns the sentiment of the document.
     *
     * Example:
     * ```
     * $sentiment = $annotation->sentiment();
     *
     * if ($sentiment['score'] > 0) {
     *     echo 'This is a positive message.';
     * }
     * ```
     *
     * @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Sentiment Sentiment type documentation
     *
     * @return array|null
     */
    public function sentiment()
    {
        return isset($this->info['documentSentiment']) ? $this->info['documentSentiment'] : null;
    }

    /**
     * Returns an array of tokens filtered by the given tag.
     *
     * Example:
     * ```
     * $tokens = $annotation->tokensByTag('NOUN');
     *
     * foreach ($tokens as $token) {
     *     echo $token['lemma'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Token#Tag Token tags documentation
     * @codingStandardsIgnoreEnd
     *
     * @return array|null
     */
    public function tokensByTag($tag)
    {
        return $this->filter(
            $this->tokens(),
            ['partOfSpeech', 'tag'],
            $tag
        );
    }

    /**
     * Returns an array of tokens filtered by the given label.
     *
     * Example:
     * ```
     * $tokens = $annotation->tokensByLabel('P');
     *
     * foreach ($tokens as $token) {
     *     echo $token['lemma'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Token#Label Token labels documentation
     * @codingStandardsIgnoreEnd
     *
     * @return array|null
     */
    public function tokensByLabel($label)
    {
        return $this->filter(
            $this->tokens(),
            ['dependencyEdge', 'label'],
            $label
        );
    }

    /**
     * Returns an array of entities filtered by the given type.
     *
     * Example:
     * ```
     * $entities = $annotation->entitiesByType('PERSON');
     *
     * foreach ($entities as $entity) {
     *     echo $entity['name'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/natural-language/docs/reference/rest/v1beta1/Entity#Type Entity types documentation
     * @codingStandardsIgnoreEnd
     *
     * @return array|null
     */
    public function entitiesByType($type)
    {
        return $this->filter(
            $this->entities(),
            ['type'],
            $type
        );
    }

    /**
     * Filters an array of items based on the provided type.
     *
     * @param array $items The items to iterate.
     * @param array $path The path to the value to compare against the provided
     *        type.
     * @param string $type The type to filter on.
     * @return array|null
     */
    private function filter($items, $path, $type)
    {
        if (!$items) {
            return null;
        }

        return array_filter($items, function ($item) use ($path, $type) {
            $itemCopy = $item;

            // key into the value with the given path
            foreach ($path as $key) {
                $itemCopy = $itemCopy[$key];
            }

            if (strtolower($itemCopy) === strtolower($type)) {
                return $item;
            }
        });
    }
}
