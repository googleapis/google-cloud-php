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

/**
 * Represents a SafeSearch annotation result
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
 */
class SafeSearch implements FeatureInterface
{
    use CallTrait;
    use FeatureTrait;
    use LikelihoodTrait;

    private $results;

    /**
     * Create a SafeSearch annotation result
     *
     * This class is instantiated internally and is used to represent the result of Cloud Vision's SafeSearch annotation
     * feature. It should not be instantiated directly. For complete usage instructions, please refer to
     * {@see Google\Cloud\Vision\Annotation::safeSearch()}.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder();
     * $vision = $cloud->vision();
     *
     * $image = $vision->image(fopen(__DIR__ .'/assets/family-photo.jpg', 'r'), [ 'safeSearch' ]);
     * $annotation = $vision->annotate($image);
     *
     * $safeSearch = $annotation->safeSearch();
     * ```
     *
     * @param array $results The SafeSearch annotation result
     */
    public function __construct(array $results)
    {
        $this->results = $results;
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
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `SafeSearch::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isAdult($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->results['adult'], $strength);
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
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `SafeSearch::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isSpoof($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->results['spoof'], $strength);
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
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `SafeSearch::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isMedical($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->results['medical'], $strength);
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
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `SafeSearch::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isViolent($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->results['violence'], $strength);
    }
}
