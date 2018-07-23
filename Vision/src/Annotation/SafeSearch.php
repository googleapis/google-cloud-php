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

namespace Google\Cloud\Vision\Annotation;

use Google\Cloud\Core\CallTrait;

/**
 * Represents a SafeSearch annotation result
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'safeSearch' ]);
 * $annotation = $vision->annotate($image);
 *
 * $safeSearch = $annotation->safeSearch();
 * ```
 *
 * @method adult() {
 *     Represents the adult contents likelihood for the image.
 *
 *     Example:
 *     ```
 *     echo $safeSearch->adult();
 *     ```
 *
 *     @return string
 * }
 * @method spoof() {
 *     Spoof likelihood. The likelihood that an obvious modification was made to
 *     the image's canonical version to make it appear funny or offensive.
 *
 *     Example:
 *     ```
 *     echo $safeSearch->spoof();
 *     ```
 *
 *     @return string
 * }
 * @method medical() {
 *     Likelihood this is a medical image.
 *
 *     Example:
 *     ```
 *     echo $safeSearch->medical();
 *     ```
 *
 *     @return string
 * }
 * @method violence() {
 *     Violence likelihood.
 *
 *     Example:
 *     ```
 *     echo $safeSearch->violence();
 *     ```
 *
 *     @return string
 * }
 * @method racy() {
 *     Racy likelihood.
 *
 *     Example:
 *     ```
 *     echo $safeSearch->racy();
 *     ```
 *
 *     @return string
 * }
 * @method info() {
 *     Get the raw annotation result
 *
 *     Example:
 *     ```
 *     $info = $safeSearch->info();
 *     ```
 *
 *     @return array
 * }
 *
 * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#SafeSearchAnnotation SafeSearchAnnotation
 */
class SafeSearch extends AbstractFeature
{
    use CallTrait;
    use LikelihoodTrait;

    /**
     * Create a SafeSearch annotation result
     *
     * This class is instantiated internally and is used to represent the result of Cloud Vision's SafeSearch annotation
     * feature. It should not be instantiated directly. For complete usage instructions, please refer to
     * {@see Google\Cloud\Vision\Annotation::safeSearch()}.
     *
     * @param array $info The SafeSearch annotation result
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }

    /**
     * Check whether the image contains adult content.
     *
     * Example:
     * ```
     * if ($safeSearch->isAdult()) {
     *     echo "Image contains adult content.";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `SafeSearch::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isAdult($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['adult'], $strength);
    }

    /**
     * Check whether the image was modified to make it appear funny or offensive.
     *
     * Example:
     * ```
     * if ($safeSearch->isSpoof()) {
     *     echo "Image contains spoofed content.";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `SafeSearch::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isSpoof($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['spoof'], $strength);
    }

    /**
     * Check whether the image contains medical content
     *
     * Example:
     * ```
     * if ($safeSearch->medical()) {
     *     echo "Image contains medical content.";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `SafeSearch::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isMedical($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['medical'], $strength);
    }

    /**
     * Check whether the image contains violent content
     *
     * Example:
     * ```
     * if ($safeSearch->isViolent()) {
     *     echo "Image contains violent content.";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `SafeSearch::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isViolent($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['violence'], $strength);
    }

    /**
     * Check whether the image contains racy content
     *
     * Example:
     * ```
     * if ($safeSearch->isRacy()) {
     *     echo "Image contains racy content.";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `SafeSearch::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isRacy($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['racy'], $strength);
    }
}
