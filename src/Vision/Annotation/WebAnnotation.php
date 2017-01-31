<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Vision\Annotation;

use Google\Cloud\Vision\Annotation\Web\WebEntity;
use Google\Cloud\Vision\Annotation\Web\WebImage;
use Google\Cloud\Vision\Annotation\Web\WebPage;

/**
 * Represents a Web Annotation result
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $vision = $cloud->vision();
 *
 * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'web' ]);
 * $annotation = $vision->annotate($image);
 *
 * $web = $annotation->web();
 * ```
 */
class WebAnnotation extends AbstractFeature
{
    /**
     * @var WebEntity[]
     */
    private $entities;

    /**
     * @var WebImage[]
     */
    private $matchingImages;

    /**
     * @var WebImage[]
     */
    private $partialMatchingImages;

    /**
     * @var WebPage[]
     */
    private $pages;

    /**
     * Create a WebAnnotation result.
     *
     * @param array $info The annotation result
     */
    public function __construct($info)
    {
        $this->info = $info;

        if (isset($info['webEntities'])) {
            $this->entities = [];

            foreach ($info['webEntities'] as $entity) {
                $this->entities[] = new WebEntity($entity);
            }
        }

        if (isset($info['fullMatchingImages'])) {
            $this->matchingImages = [];

            foreach ($info['fullMatchingImages'] as $image) {
                $this->matchingImages[] = new WebImage($image);
            }
        }

        if (isset($info['partialMatchingImages'])) {
            $this->partialMatchingImages = [];

            foreach ($info['partialMatchingImages'] as $image) {
                $this->partialMatchingImages[] = new WebImage($image);
            }
        }

        if (isset($info['pagesWithMatchingImages'])) {
            $this->pages = [];

            foreach ($info['pagesWithMatchingImages'] as $page) {
                $this->pages[] = new WebPage($page);
            }
        }
    }

    /**
     * Entities deduced from similar images on the Internet.
     *
     * Example:
     * ```
     * $entities = $web->entities();
     * ```
     *
     * @return WebEntity[]
     */
    public function entities()
    {
        return $this->entities;
    }

    /**
     * Fully matching images from the internet.
     *
     * Images are most likely near duplicates, and most often are a copy of the
     * given query image with a size change.
     *
     * Example:
     * ```
     * $images = $web->matchingImages();
     * ```
     *
     * @return WebImage[]
     */
    public function matchingImages()
    {
        return $this->matchingImages;
    }

    /**
     * Partial matching images from the Internet.
     *
     * Those images are similar enough to share some key-point features. For
     * example an original image will likely have partial matching for its crops.
     *
     * Example:
     * ```
     * $images = $web->partialMatchingImages();
     * ```
     *
     * @return WebImage[]
     */
    public function partialMatchingImages()
    {
        return $this->partialMatchingImages;
    }

    /**
     * Web pages containing the matching images from the Internet.
     *
     * Example:
     * ```
     * $pages = $web->pages();
     * ```
     *
     * @return WebPage[]
     */
    public function pages()
    {
        return $this->pages;
    }
}
